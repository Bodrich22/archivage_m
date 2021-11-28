<?php

namespace App\Controller\Admin;


use App\Entity\Users;
use App\Form\UsersType;
use App\Repository\UsersRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;



/**
 * @Route("/admin/users", name="admin_users_")
 * @package App\controller\Admin
 */

class UsersController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(UsersRepository $usersRepo)
    {
        return $this->render('admin/archives/user.html.twig', [
            'users' => $usersRepo->findAll()
        ]);
    }

    /**
     * @Route("/ajout", name="ajout")
     */
    public function ajoutusers(Request $request)
    {
        $users = new Users;

        $form = $this->createForm(UsersType::class, $users);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($users);
            $em->flush();

            return $this->redirectToRoute('admin_users_home');
        }

        return $this->render('admin/users/ajout.html.twig', [
            'form'  => $form->createView()
        ]);
    }

    /**
     * @Route("/modifier/{id}", name="modifier")
     */
    public function modifArchive(Users $users, Request $request)
    {

        $form = $this->createForm(UsersType::class, $users);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($users);
            $em->flush();

            return $this->redirectToRoute('admin_users_home');
        }

        return $this->render('admin/users/ajout.html.twig', [
            'form'  => $form->createView()
        ]);
    }
}
