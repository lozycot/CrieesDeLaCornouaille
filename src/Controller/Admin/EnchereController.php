<?php

namespace App\Controller\Admin;

use App\Entity\Enchere;
use App\Form\EnchereType;
use App\Service\VenteVerification;
use App\Repository\LotRepository;
use App\Repository\VenteRepository;
use App\Repository\EnchereRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use DateTime;

#[Route('/admin/enchere')]
final class EnchereController extends AbstractController
{
    #[Route('', name: 'app_admin_enchere')]
    public function index(?LotRepository $lotRepo, ?VenteRepository $venteRepo, ?EnchereRepository $enchereRepo, VenteVerification $venteVerification): Response
    {
        $dateActuelle = new DateTime("now");
        $vente = $venteRepo->findProchaineVente();
        $venteEstOuverte = $venteVerification->venteEstOuverte($vente);

        
        // si la vente n'est pas ouverte, retourner sur la page Vente
        if(!$venteEstOuverte) {
            return $this->redirectToRoute("app_vente");
        } else { // sinon aller sur la page enchères

            $enchere = new Enchere();
            $form = $this->createForm(EnchereType::class, $enchere);
            
            // récupérer les lots
            $lots = $lotRepo->findBy(array("dateEnchere" => $dateActuelle), array("heureDebutEnchere" => "ASC"));

            // chercher le lot actuellement ouvert à la vente, si il y en a un
            $lotActuel = null;

            foreach($lots as $unLot) {
                if($unLot->getHeureDebutEnchere()->format("H:i") <= $dateActuelle->format("H:i"))
                    $lotActuel = $unLot;
            }

            $encheres = null;

            // trouver les enchères pour ce lot
            if($lotActuel != null) {
                $encheres = $enchereRepo->findBy(array("lot" => $lotActuel));
            }

            return $this->render('admin/enchere/index.html.twig', [
                'controller_name' => 'EnchereController',
                'lots' => $lots,
                'dateActuelle' => $dateActuelle,
                'idLotActuel' => $lotActuel->getId(),
                'form' => $form,
                'encheres' => $encheres,
            ]);
        }
    }
}
