<?php

namespace App\Controller;

use App\Entity\Avis;
use App\Entity\Article;
use App\Form\AvisType;
use App\Repository\ArticleRepository;
use App\Repository\AvisRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/avis')]
class AvisController extends AbstractController
{
    #[Route('/', name: 'app_avis_index', methods: ['GET'])]
    public function index(AvisRepository $avisRepository): Response
    {
        return $this->render('avis/index.html.twig', [
            'avis' => $avisRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_avis_new', methods: ['POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, ArticleRepository $articleRepository): Response
    {
        $avi = new Avis();

        // Récupérer les données du formulaire
        $text = $request->request->get('text');
        $rating = $request->request->get('rating');
        $articleId = $request->request->get('article_id');

        // Récupérer l'article correspondant
        $article = $articleRepository->find($articleId);

        // Associer les données à l'avis
        if ($article) {
            $avi->setArticle($article);
        }
        $avi->setContenu($text);
        $avi->setNote((int)$rating);

        // Associer l'avis à l'utilisateur connecté
        $avi->setUtilisateur($this->getUser());

        $entityManager->persist($avi);
        $entityManager->flush();

        return $this->redirectToRoute('blog_single', ['slug' => $article->getSlug()], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{id}', name: 'app_avis_show', methods: ['GET'])]
    public function show(Avis $avi): Response
    {
        return $this->render('avis/show.html.twig', [
            'avi' => $avi,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_avis_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Avis $avi, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(AvisType::class, $avi);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_avis_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('avis/edit.html.twig', [
            'avi' => $avi,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_avis_delete', methods: ['POST'])]
    public function delete(Request $request, Avis $avi, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $avi->getId(), $request->request->get('_token'))) {
            $entityManager->remove($avi);
            $entityManager->flush();
        }

        return $this->redirectToRoute('blog-full-width', [], Response::HTTP_SEE_OTHER);
    }
}
