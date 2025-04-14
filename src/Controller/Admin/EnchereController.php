<?php

namespace App\Controller\Admin;

use App\Service\VenteVerification;
use App\Repository\LotRepository;
use App\Repository\VenteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use DateTime;

#[Route('/admin/enchere')]
final class EnchereController extends AbstractController
{
    #[Route('', name: 'app_admin_enchere')]
    public function index(?LotRepository $lotRepo, ?VenteRepository $venteRepo, VenteVerification $venteVerification): Response
    {
        $dateActuelle = new DateTime("now");
        $vente = $venteRepo->findProchaineVente();
        $venteEstOuverte = $venteVerification->venteEstOuverte($vente);

        // si la vente n'est pas ouverte, retourner sur la page Vente
        if(!$venteEstOuverte) {
            return $this->redirectToRoute("app_vente");
        } else { // sinon aller sur la page enchères

            // récupérer les lots
            $lots = $lotRepo->findBy(array("dateEnchere" => $dateActuelle), array("heureDebutEnchere" => "ASC"));

            // chercher le lot actuellement ouvert à la vente, si il y en a un
            $idLotActuel = -1;
            foreach($lots as $unLot) {
                if($unLot->getHeureDebutEnchere()->format("H:i") <= $dateActuelle->format("H:i"))
                    $idLotActuel = $unLot->getId();
            }

            return $this->render('admin/enchere/index.html.twig', [
                'controller_name' => 'EnchereController',
                'lots' => $lots,
                'dateActuelle' => $dateActuelle,
                'idLotActuel' => $idLotActuel,
            ]);
        }
    }
}
