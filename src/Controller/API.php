<?php

namespace App\Controller;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use DateTimeInterface;
use PHPUnit\TextUI\XmlConfiguration\Groups;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/api/v1', name: 'api_')]
class API extends AbstractController
{

    #[Route('/allarticles', name: 'articles')]
    public function index(ArticleRepository $articleRepository, SerializerInterface $serializer): Response
    {
        $articles = $articleRepository->findAll();






        $jsonContent = $serializer->serialize($articles, 'json', ["groups" => "article"]);

       return new JsonResponse($jsonContent, 200, [], true);
    }

    #[Route('/article/{id}', name: 'article')]
    public function article(ArticleRepository $articleRepository, SerializerInterface $serializer, $id): JsonResponse
    {
        $article = $articleRepository->findBy(['id' => $id]);





        $jsonContent = $serializer->serialize($article, 'json', ["groups" => "article"]);

        return $this->json($jsonContent, 200, [], ['groups' => 'article']);
    }






}