<?php

namespace App\Controller;

use App\Entity\Archive;
use App\Form\ArchiveType;
use App\Repository\ArchiveRepository;
use App\Repository\ServiceRepository;
use Symfony\Contracts\Cache\ItemInterface;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;



/**
 * @Route("/archives", name="_archives_")
 * @package App\controller\
 */

class ArchivesController extends AbstractController
{
    /**
     * @Route("/", name="home")
     * @return void 
     */

    public function index(ArchiveRepository $archRepo, ServiceRepository $servRepo, Request $request, CacheInterface $cache)
    {

        // On définit le nombre d'éléments par page
        $limit = 10;

        // On récupère le numéro de page
        $page = (int)$request->query->get("page", 1);

        // On récupère les filtres
        $filters = $request->get("service");

        // On récupère les archives de la page en fonction du filtre
        $archives = $archRepo->getPaginatedArchives($page, $limit, $filters);

        // On récupère le nombre total d'archives 
        $total = $archRepo->getTotalArchives($filters);



        // On vérifie si on a une requête Ajax
        if ($request->get('ajax')) {
            return new JsonResponse([
                'content' => $this->renderView('archives/content.html.twig', compact('archives', 'total', 'limit', 'page'))
            ]);
        }

        // On va chercher toutes les services 
        $service  = $cache->get('service_list', function (ItemInterface $item) use ($servRepo) {
            $item->expiresAfter(3600);

            return $servRepo->findAll();
        });

        return $this->render('archives/index.html.twig', [
            'archives' => $archRepo->findAll()
        ]);
    }
}
