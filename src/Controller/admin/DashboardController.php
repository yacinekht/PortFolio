<?php

namespace App\Controller\admin;

use EasyCorp\Bundle\EasyAdminBundle\Attribute\AdminDashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;

#[AdminDashboard(routePath: '/admin', routeName: 'admin')]
class DashboardController extends AbstractDashboardController
{
    public function index(): Response
    {
        return $this->redirectToRoute('admin_skill_index');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Portfolio');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkTo(\App\Controller\admin\SkillCrudController::class, 'Compétences', 'fas fa-code');
        yield MenuItem::linkTo(\App\Controller\admin\TrainingCrudController::class, 'Formations', 'fas fa-graduation-cap');
        yield MenuItem::linkTo(\App\Controller\admin\ExperienceCrudController::class, 'Expériences', 'fas fa-briefcase');
        yield MenuItem::linkTo(\App\Controller\admin\CvDocumentCrudController::class, 'Mon CV', 'fas fa-file-pdf');
        yield MenuItem::linkTo(\App\Controller\admin\PassionCrudController::class, 'Passions', 'fas fa-heart');
    }
}
