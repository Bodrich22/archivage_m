<?php

namespace App\Controller\Admin;

use App\Repository\ArchiveRepository;
use App\Repository\CategoryRepository;
use App\Repository\ServiceRepository;
use App\Repository\UsersRepository;
use App\Entity\Users;
use App\Entity\Archive;
use App\Entity\Service;
use App\Entity\Category;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{

    public function __construct(ArchiveRepository $archRepository, CategoryRepository $catRepository, UsersRepository $usersRepository, ServiceRepository $servRepository)
    {
        $this->ArchiveRepository = $archRepository;
        $this->CategoryRepository = $catRepository;
        $this->ServiceRepository = $servRepository;
        $this->UsersRepository = $usersRepository;
    }

    /**
     * @Route("/admin_dash", name="admin_dash")
     */
    public function index(): Response
    {
        return $this->render('bundles/EasyAdminBundles/welcome.html.twig', [
            'CountAllUsers' => $this->UsersRepository->CountAllUsers(),
            'CountAllArchives' => $this->ArchiveRepository->CountAllArchives(),
            'services' => $this->ServiceRepository->findAll(),
            'Categories' => $this->CategoryRepository->findAll(),
        ]);
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Archivage Minpostel');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linktoDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('Archives', 'fas fa-archive', Archive::class);
        yield MenuItem::linkToCrud('Utilisateurs', 'fas fa-user', Users::class);
        yield MenuItem::linkToCrud('Services', 'fas fa-list', Service::class);
        yield MenuItem::linkToCrud('Categories', 'fas fa-bars', Category::class);
        // yield MenuItem::linkToCrud('The Label', 'fas fa-list', EntityClass::class);
    }
}
