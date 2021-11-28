<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('bundles/EasyAdminBundles/page/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
            'page_title' => 'MPT_DATA Login',
            'username_label' => 'email',
            'password_label' => 'password',
            'csrf_token_intention' => 'authenticate',
            'target_path' => $this->generateUrl('admin_dash'),
            'username_parameter' => 'email',
            'password_parameter' => 'password',



        ]);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout()
    {
        return $this->render('bundles/EasyAdminBundles/page/login.html.twig');
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
