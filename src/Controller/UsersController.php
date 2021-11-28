<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UsersController extends AbstractController
{
    /**
     * @Route("/users", name="users")
     */
    public function index(): Response
    {
        return $this->render('users/index.html.twig', [
            'controller_name' => 'UsersController',
        ]);
    }


    /**
     * @Route("/users/archives/afficher", name="users_archives_afficher")
     */
    public function afficher(): Response
    {
        return $this->render('users/archives/afficher.html.twig', [
            'controller_name' => 'UsersController',
        ]);
    }


    /**
     * @Route("/users/archives/rechercher", name="users_archives_rechercher")
     */
    public function rechercher(): Response
    {
        return $this->render('users/archives/rechercher.html.twig', [
            'controller_name' => 'UsersController',
        ]);
    }
}
