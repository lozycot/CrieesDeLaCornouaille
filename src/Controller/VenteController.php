<?php

namespace App\Controller;

use App\Repository\LotRepository;
use App\Repository\VenteRepository;
use App\Service\VenteVerification;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use DateTime;

class VenteController extends AbstractController
{
    #[Route('/vente', name: 'app_vente')]
    public function index(?VenteRepository $repository, VenteVerification $venteVerification, LotRepository $lotRepository): Response
    {
        $ventes = $repository->findProchainesVentes();
        $dateActuelle = new DateTime("now");
        $venteOuverte = false;
        if($ventes != null)
            $venteOuverte = $venteVerification->venteEstOuverte($ventes[0]);

        // Fetch all ventes for the calendrier
        $ventes = $repository->findBy([], ['dateVente' => 'ASC', 'heureDebut' => 'ASC']);

        // Fetch lots for the next vente (if any)
        $lotsProchaineVente = [];
        if ($vente) {
            $lotsProchaineVente = $vente->getLots();
        }

        return $this->render('vente/index.html.twig', [
            'controller_name' => 'VenteController',
            'ventes' => $ventes,
            'dateActuelle' => $dateActuelle,
            'venteOuverte' => $venteOuverte,
            'ventes' => $ventes,
            'lotsProchaineVente' => $lotsProchaineVente,
        ]);
    }
}
