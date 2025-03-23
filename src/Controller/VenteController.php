<?php

namespace App\Controller;

use App\Entity\Vente;
use App\Repository\LotRepository;
use App\Repository\VenteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use DateTime;

class VenteController extends AbstractController
{
    #[Route('/vente', name: 'app_vente')]
    public function index(?VenteRepository $repository): Response
    {
        $vente = $repository->findProchaineVente();
        $dateActuelle = new DateTime("now");
        $venteOuverte = false;

        // vérifie si la prochaine vente existe et si elle est ouverte
        if($vente->getDateVente()->format('d-m-Y') == $dateActuelle->format('d-m-Y') &&
           $vente->getHeureDebut()->format('H:i') <= $dateActuelle->format('H:i') &&
           $vente->getHeureFin()->format('H:i') > $dateActuelle->format('H:i')) {
            $venteOuverte = true;
        }

        return $this->render('vente/index.html.twig', [
            'controller_name' => 'VenteController',
            'vente' => $vente,
            'dateActuelle' => $dateActuelle,
            'venteOuverte' => $venteOuverte,
        ]);
    }

    #[Route('/vente/encheres', name: 'app_vente_encheres')]
    public function encheres(?LotRepository $repository): Response
    {
        $dateActuelle = new DateTime("now");
        $lots = $repository->findBy(array("dateEnchere" => $dateActuelle));
        return $this->render('vente/encheres.html.twig', [
            'controller_name' => 'VenteController',
            'lots' => $lots,
            'dateActuelle' => $dateActuelle,
        ]);
    }
}
