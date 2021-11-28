<?php

namespace App\Controller;

use App\Form\SearchArchiveType;
use App\Repository\ArchiveRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="app_home")
     */
    public function index(ArchiveRepository $archRepo, Request $request)
    {
        $archives = $archRepo->findBy(['id' => true], ['date_archivage' => 'desc'], 5);

        $form = $this->createForm(SearchArchiveType::class);

        $search = $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // On recherche les archives correspondant aux mots clés
            $archives = $archRepo->search(
                $search->get('mots')->getData(),
                $search->get('service')->getData()
            );
        }

        return $this->render('main/index.html.twig', [
            'archive' => $archives,
            'form' => $form->createView()
        ]);
    }
}
