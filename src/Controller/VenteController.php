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
    public function index(?VenteRepository $repository, VenteVerification $venteVerification): Response
    {
        $vente = $repository->findProchaineVente();
        $dateActuelle = new DateTime("now");
        $venteOuverte = $venteVerification->venteEstOuverte($vente);

        return $this->render('vente/index.html.twig', [
            'controller_name' => 'VenteController',
            'vente' => $vente,
            'dateActuelle' => $dateActuelle,
            'venteOuverte' => $venteOuverte,
        ]);
    }

    // #[Route('/vente/encheres', name: 'app_vente_encheres')]
    // public function encheres(?LotRepository $lotRepo, ?VenteRepository $venteRepo, VenteVerification $venteVerification): Response
    // {
    //     $dateActuelle = new DateTime("now");
    //     $vente = $venteRepo->findProchaineVente();
    //     $venteEstOuverte = $venteVerification->venteEstOuverte($vente);

    //     // si la vente n'est pas ouverte, retourner sur la page Vente
    //     if(!$venteEstOuverte) {
    //         return $this->render('vente/index.html.twig', [
    //             'controller_name' => 'VenteController',
    //             'vente' => $vente,
    //             'dateActuelle' => $dateActuelle,
    //             'venteOuverte' => $venteEstOuverte,
    //         ]);
    //     } else { // sinon aller sur la page enchères

    //         // récupérer les lots
    //         $lots = $lotRepo->findBy(array("dateEnchere" => $dateActuelle), array("heureDebutEnchere" => "ASC"));

    //         // chercher le lot actuellement ouvert à la vente, si il y en a un
    //         $idLotActuel = -1;
    //         foreach($lots as $unLot) {
    //             if($unLot->getHeureDebutEnchere()->format("H:i") <= $dateActuelle->format("H:i"))
    //                 $idLotActuel = $unLot->getId();
    //         }

    //         return $this->render('vente/encheres.html.twig', [
    //             'controller_name' => 'VenteController',
    //             'lots' => $lots,
    //             'dateActuelle' => $dateActuelle,
    //             'idLotActuel' => $idLotActuel,
    //         ]);
    //     }
    // }
}
