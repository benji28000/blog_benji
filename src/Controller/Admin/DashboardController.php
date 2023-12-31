<?php

// src/Controller/Admin/DashboardController.php
namespace App\Controller\Admin;

use App\Entity\Article;
use App\Entity\Avis;
use App\Entity\Categorie;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);

        return $this->redirect($adminUrlGenerator->setController(ArticleCrudController::class)->generateUrl());

    }

    public function configureDashbrd(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('ACME Corp.');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('Articles', 'fas fa-list', Article::class);
        yield MenuItem::linktoCrud("Categories", "fas fa-list", Categorie::class);
        yield MenuItem::LinkToCrud("Avis", "fas fa-list", Avis::class);
        yield MenuItem::LinkToCrud("Users", "fas fa-list", User::class);

    }


// ...
}