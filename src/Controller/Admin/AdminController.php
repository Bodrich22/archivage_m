<?php

namespace App\Controller\Admin;

use App\Entity\Archive;

use App\Form\ArchiveType;
use App\Repository\ArchiveRepository;
use App\Repository\ServiceRepository;
use App\Entity\Category;
use App\Form\CategoryType;
use App\Entity\Service;
use App\Form\ServiceType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;



/**
 * @Route("/admin", name="admin_")
 * @package App\controller\Admin
 */

class AdminController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(ArchiveRepository $archRepo, Request $request)
    {
        // on définit le nombre d'éléments par page
        $limit = 10;

        // on recupere le numéro de pages 
        $page = (int)$request->query->get("page", 1);

        //on recupere les archives de la page
        $archives = $archRepo->getPaginatedArchives($page, $limit);

        // on recupere le nombre total d'archive
        $total = $archRepo->getTotalArchives();

        return $this->render(
            'admin/index.html.twig',
            compact('archives', 'total', 'limit', 'page')
        );
    }

    /**
     * @Route("/archives/ajout", name="archives_ajout")
     */
    public function ajoutArchive(Request $request)
    {
        $archives = new Archive;

        $form = $this->createForm(ArchiveType::class, $archives);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($archives);
            $em->flush();

            return $this->redirectToRoute('admin_home');
        }

        return $this->render('admin/archives/ajout.html.twig', [
            'form'  => $form->createView()
        ]);
    }

    /**
     * @Route("/category/ajout", name="category_ajout")
     */
    public function ajoutCategory(Request $request)
    {
        $category = new Category;

        $form = $this->createForm(CategoryType::class, $category);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($category);
            $em->flush();

            return $this->redirectToRoute('admin_home');
        }

        return $this->render('admin/category/ajout.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/Service/ajout", name="Service_ajout")
     */
    public function ajoutService(Request $request)
    {
        $Service = new Service;

        $form = $this->createForm(ServiceType::class, $Service);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($Service);
            $em->flush();

            return $this->redirectToRoute('admin_home');
        }

        return $this->render('admin/Service/ajout.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/stats", name="stats")
     */
    public function statistiques(ServiceRepository $serviRepo, ArchiveRepository $archRepo)
    {
        // On va chercher toutes les Services
        $services = $serviRepo->findAll();

        $serviTitre = [];


        // On "démonte" les données pour les séparer tel qu'attendu par ChartJS
        foreach ($services as $service) {
            $erviTitre[] = $service->getTitre();
            $erviCount[] = count($service->getArchives());
        }

        // On va chercher le nombre d'Archives publiées par date
        $archives = $archRepo->countByDate();

        $dates = [];
        $archivesCount = [];

        // On "démonte" les données pour les séparer tel qu'attendu par ChartJS
        foreach ($archives as $archive) {
            $dates[] = $archive['dateArchives'];
            $ArchivesCount[] = $archive['count'];
        }

        return $this->render('admin/stats.html.twig', [
            'serviTitre' => json_encode($serviTitre),
            'serviCount' => json_encode($serviCount),
            'dates' => json_encode($dates),
            'ArchivesCount' => json_encode($archivesCount),
        ]);
    }
}
