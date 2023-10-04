<?php

namespace App\Controller;


use App\Repository\ArticleRepository;
use App\Repository\CategorieRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use PhpParser\Builder\Method;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\HttpFoundation\Request;

class BlogController extends AbstractController
{
    #[Route('/', name: 'blog_index')]
    public function index(): Response
    {
        return $this->render('blog/index.html.twig');
    }
    #[Route('/404', name: '404')]
    public function error(): Response
    {
        return $this->render('blog/404.html.twig');
    }
    #[Route('/about', name: 'about')]
    public function about(): Response
    {
        return $this->render('blog/about.html.twig');
    }
    #[Route('/blog-full-width/{categorie}', name: 'blog-full-width', defaults: ['categorie' => null])]
    public function blog_full_width(?string $categorie,ArticleRepository $articleRepository, CategorieRepository $categorieRepository): Response
    {
        if ($categorie) {
            return $this->render('blog/blog-full-width.html.twig', [
                'articles' => $articleRepository->findBy(['MaCategorie' => $categorieRepository->findBy(["slug" => $categorie])]),
            ]);
        }
        return $this->render('blog/blog-full-width.html.twig', [
            'articles' => $articleRepository->findAll(),
        ]);
    }
    #[Route('/blog-grid', name: 'blog-grid')]
    public function blog_grid(): Response
    {
        return $this->render('blog/blog-grid.html.twig');
    }
    #[Route('/blog-left-sidebar', name: 'blog-left-sidebar')]
    public function blog_left_sidebar(): Response
    {
        return $this->render('blog/blog-left-sidebar.html.twig');
    }
    #[Route('/blog-right-sidebar', name: 'blog-right-sidebar')]
    public function blog_right_sidebar(): Response
    {
        return $this->render('blog/blog-right-sidebar.html.twig');
    }
    #[Route('/blog-single', name: 'blog-single')]
    public function blog_single(): Response
    {
        return $this->render('blog/blog-single.html.twig');
    }
    #[Route('/coming-soon', name: 'coming-soon')]
    public function coming_soon(): Response
    {
        return $this->render('blog/coming-soon.html.twig');
    }
    #[Route('/contact', name: 'contact')]
    public function contact(): Response
    {
        return $this->render('blog/contact.html.twig');
    }
    #[Route('/faq', name: 'faq')]
    public function faq(): Response
    {
        return $this->render('blog/faq.html.twig');
    }
    #[Route('/portfolio', name: 'portfolio')]
    public function portfolio(): Response
    {
        return $this->render('blog/portfolio.html.twig');
    }
    #[Route('/portfolio-single', name: 'portfolio-single')]
    public function portfolio_single(): Response
    {
        return $this->render('blog/portfolio-single.html.twig');
    }
    #[Route('/pricing', name: 'pricing')]
    public function pricing(): Response
    {
        return $this->render('blog/pricing.html.twig');
    }
    #[Route('/service', name: 'service')]
    public function service(): Response
    {
        return $this->render('blog/service.html.twig');
    }


    #[Route("/search", name: "search")]

    public function search_article(Request $request, CategorieRepository $categorieRepository, ArticleRepository $articleRepository): Response
    {
        $searchTerm = $request->request->get('search');




        $result=strtolower($searchTerm);
        $category = $categorieRepository->findOneBy(["slug" => $result]);


        if ($category) {
            $articles = $category->getArticles();
        } else {


            $articles = $articleRepository->findBy(['titre' => $searchTerm]);

        }



        return $this->render('blog/blog-full-width.html.twig', [
            'categories' => $categorieRepository->findAll(),
            'articles' => $articles,
        ]);
    }

}