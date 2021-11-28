<?php

namespace App\Controller\Admin;

use App\Entity\Service;
use App\Form\ServiceType;
use App\Repository\ServiceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Cache\CacheInterface;

/**
 * @Route("/admin/Service", name="admin_Service_")
 * @package App\Controller\Admin
 */
class ServiceController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(ServiceRepository $ServRepo)
    {
        return $this->render('admin/Service/index.html.twig', [
            'Service' => $ServRepo->findAll()
        ]);
    }

    /**
     * @Route("/ajout", name="ajout")
     */
    public function ajoutService(Request $request, CacheInterface $cache)
    {
        $Service = new Service;

        $form = $this->createForm(ServiceType::class, $Service);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($Service);
            $em->flush();

            // On efface le cache
            $cache->delete('Service_list');

            return $this->redirectToRoute('admin_Service_home');
        }

        return $this->render('admin/Service/ajout.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/modifier/{id}", name="modifier")
     */
    public function ModifService(Service $Service, Request $request, CacheInterface $cache)
    {
        $form = $this->createForm(CServiceType::class, $Service);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($Service);
            $em->flush();

            // On supprime le cache
            $cache->delete('Service_list');

            return $this->redirectToRoute('admin_Service_home');
        }

        return $this->render('admin/Service/ajout.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
