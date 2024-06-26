<?php

namespace App\Controller;


use App\Entity\Article;
use App\Form\Article1Type;
use App\Repository\ArticleRepository;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\Slugger;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/article')]
class ArticleController extends AbstractController
{
    #[Route('/', name: 'app_article_index', methods: ['GET'])]
    public function index(ArticleRepository $articleRepository): Response
    {
        return $this->render('article/index.html.twig', [
            'articles' => $articleRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_article_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $article = new Article();
        $form = $this->createForm(Article1Type::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $decodedTitle = html_entity_decode($article->getTitre(), ENT_QUOTES | ENT_HTML5, 'UTF-8');
            $article->setTitre($decodedTitle);
            // Générer le slug à partir du titre
            $slugger = new Slugger();
            $slug = $slugger->slugify($article->getTitre());
            $article->setSlug($slug);

            // Persister l'article avec le slug
            $entityManager->persist($article);
            $entityManager->flush();

            return $this->redirectToRoute('app_article_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('article/new.html.twig', [
            'article' => $article,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_article_show', methods: ['GET'])]
    public function show(Article $article): Response
    {
        return $this->render('article/show.html.twig', [
            'article' => $article,
        ]);
    }

    #[IsGranted('ROLE_ADMIN', message: 'Vous n\'avez pas les droits pour modifier cet article')]
    #[Route('/{id}/edit', name: 'app_article_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Article $article, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(Article1Type::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Décoder les entités HTML dans le titre
            $decodedTitle = html_entity_decode($article->getTitre(), ENT_QUOTES | ENT_HTML5, 'UTF-8');
            $article->setTitre($decodedTitle);

            // Générer le slug à partir du titre
            $slugger = new Slugger();
            $slug = $slugger->slugify($decodedTitle);
            $article->setSlug($slug);

            // Persister l'article avec le titre décodé et le slug
            $entityManager->flush();

            return $this->redirectToRoute('app_article_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('article/edit.html.twig', [
            'article' => $article,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_article_delete', methods: ['POST'])]
    public function delete(Request $request, Article $article, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$article->getId(), $request->request->get('_token'))) {
            $entityManager->remove($article);
            $entityManager->flush();
        }

        return $this->redirectToRoute('blog-full-width', [], Response::HTTP_SEE_OTHER);
    }

    public function get_articles(ArticleRepository $articleRepository): Response
    {
        return $this->render('article/recent_article.html.twig', [
            'articles' => $articleRepository->findBy([], ['date' => 'DESC'], 3),
        ]);
    }

    public  function  numberofarticles(ArticleRepository $articleRepository): Response
    {
        return $this->render('article/numberofarticles.html.twig', [
            'articles' => count($articleRepository->findBy([])),
        ]);
    }
}
