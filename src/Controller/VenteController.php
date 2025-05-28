<?php

namespace App\Controller;

use App\Repository\LotRepository;
use App\Repository\VenteRepository;
use App\Service\VenteVerification;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use DateTime;
use App\Controller\LotsController;

class VenteController extends AbstractController
{
    #[Route('/vente', name: 'app_vente')]
    public function index(?VenteRepository $repository, VenteVerification $venteVerification, LotRepository $lotRepository): Response
    {
        $vente = $repository->findProchaineVente();
        $dateActuelle = new DateTime("now");
        $venteOuverte = $venteVerification->venteEstOuverte($vente);

        // Fetch all ventes for the calendrier
        $ventes = $repository->findBy([], ['dateVente' => 'ASC', 'heureDebut' => 'ASC']);

        // Fetch lots for the next vente (if any)
        $lotsProchaineVente = [];
        if ($vente) {
            $lotsProchaineVente = $vente->getLots();
        }

        return $this->render('vente/index.html.twig', [
            'controller_name' => 'VenteController',
            'vente' => $vente,
            'dateActuelle' => $dateActuelle,
            'venteOuverte' => $venteOuverte,
            'ventes' => $ventes,
            'lotsProchaineVente' => $lotsProchaineVente,
        ]);
    }
}
