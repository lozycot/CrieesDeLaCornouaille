<?php

namespace App\Controller;

use App\Repository\VenteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class AccueilController extends AbstractController
{
    #[Route('/', name: 'app_accueil')]
    public function index(?VenteRepository $venteRepository): Response
    {
        $ventes = $venteRepository->findProchainesVentes();
        return $this->render('accueil/index.html.twig', [
            'ventes' => $ventes,
        ]);
    }
}
