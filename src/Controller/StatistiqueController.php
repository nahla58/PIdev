<?php

// src/Controller/StatistiqueController.php

namespace App\Controller;

use App\Repository\ActiviteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StatistiqueController extends AbstractController
{
    #[Route('/statistique', name: 'app_statistique')]
    public function index(ActiviteRepository $activiteRepository): Response
    {
        $activiteStatistics = $activiteRepository->getActiviteStatistics();

        $labels = [];
        $data = [];

        foreach ($activiteStatistics as $statistic) {
            $labels[] = $statistic['type'];
            $data[] = $statistic['count'];
        }

        return $this->render('statistique/activite.html.twig', [
            'labels' => json_encode($labels),
            'data' => json_encode($data),
        ]);
    }
    #[Route('/recherche-nom', name: 'app_recherche_nom')]
    public function rechercheNom(ActiviteRepository $activiteRepository, Request $request): Response
    {
        $searchTerm = $request->query->get('nom');
        $resultats = $activiteRepository->rechercheParNom($searchTerm);

        return $this->render('statistique/recherche_nom.html.twig', [
            'resultats' => $resultats,
        ]);
    }
}
