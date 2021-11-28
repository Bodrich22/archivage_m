<?php

namespace App\Controller\Admin;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Cache\CacheInterface;

/**
 * @Route("/admin/category", name="admin_category_")
 * @package App\Controller\Admin
 */
class CategoryController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(CategoryRepository $catsRepo)
    {
        return $this->render('admin/category/index.html.twig', [
            'category' => $catsRepo->findAll()
        ]);
    }

    /**
     * @Route("/ajout", name="ajout")
     */
    public function ajoutCategory(Request $request, CacheInterface $cache)
    {
        $category = new Category;

        $form = $this->createForm(CategoryType::class, $category);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($category);
            $em->flush();

            // On efface le cache
            $cache->delete('category_list');

            return $this->redirectToRoute('admin_category_home');
        }

        return $this->render('admin/category/ajout.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/modifier/{id}", name="modifier")
     */
    public function ModifCategorie(Category $category, Request $request, CacheInterface $cache)
    {
        $form = $this->createForm(CategoryType::class, $category);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($category);
            $em->flush();

            // On supprime le cache
            $cache->delete('category_list');

            return $this->redirectToRoute('admin_category_home');
        }

        return $this->render('admin/category/ajout.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
