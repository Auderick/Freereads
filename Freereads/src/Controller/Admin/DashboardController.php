<?php

namespace App\Controller\Admin;

use App\Entity\Book;
use App\Entity\User;
use App\Entity\Author;
use App\Entity\Status;
use App\Entity\UserBook;
use App\Entity\Publisher;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {

        $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        return $this->redirect($adminUrlGenerator->setController(BookCrudController::class)->generateUrl());

    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Freereads');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToCrud('Books', 'fas fa-book', Book::class);
        yield MenuItem::linkToCrud('Authors', 'fas fa-user-pen', Author::class);
        yield MenuItem::linkToCrud('Publishers', 'fas fa-building', Publisher::class);
        yield MenuItem::linkToCrud('Status', 'fas fa-tags', Status::class);
        yield MenuItem::linkToCrud('Users', 'fas fa-user', User::class);
        yield MenuItem::linkToCrud('UserBooks', 'fas fa-book-open', UserBook::class);
    }
}
