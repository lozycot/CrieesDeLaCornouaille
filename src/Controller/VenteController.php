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
    /**
     * Vérifie si la vente trouvée est ouverte (si on se situe dans les horaires d'ouverture)
     * @param Vente $vente
     * */
    public function venteEstOuverte(?Vente $vente): bool {
        $venteOuverte = false;
        $dateActuelle = new DateTime("now");
        // vérifie si la prochaine vente existe et si elle est ouverte
        if(is_null($vente))
            $venteOuverte = false;
        elseif($vente->getDateVente()->format('d-m-Y') == $dateActuelle->format('d-m-Y') &&
           $vente->getHeureDebut()->format('H:i') <= $dateActuelle->format('H:i') &&
           $vente->getHeureFin()->format('H:i') > $dateActuelle->format('H:i')) {
            $venteOuverte = true;
        }
        return $venteOuverte;
    }

    #[Route('/vente', name: 'app_vente')]
    public function index(?VenteRepository $repository): Response
    {
        $vente = $repository->findProchaineVente();
        $dateActuelle = new DateTime("now");
        $venteOuverte = $this->venteEstOuverte($vente);

        return $this->render('vente/index.html.twig', [
            'controller_name' => 'VenteController',
            'vente' => $vente,
            'dateActuelle' => $dateActuelle,
            'venteOuverte' => $venteOuverte,
        ]);
    }

    #[Route('/vente/encheres', name: 'app_vente_encheres')]
    public function encheres(?LotRepository $lotRepo, ?VenteRepository $venteRepo): Response
    {
        $dateActuelle = new DateTime("now");
        $vente = $venteRepo->findProchaineVente();
        $venteEstOuverte = $this->venteEstOuverte($vente);

        // si la vente n'est pas ouverte
        if(!$venteEstOuverte) {
            return $this->render('vente/index.html.twig', [
                'controller_name' => 'VenteController',
                'vente' => $vente,
                'dateActuelle' => $dateActuelle,
                'venteOuverte' => $venteEstOuverte,
            ]);
        } else {
            $lots = $lotRepo->findBy(array("dateEnchere" => $dateActuelle));
            return $this->render('vente/encheres.html.twig', [
                'controller_name' => 'VenteController',
                'lots' => $lots,
                'dateActuelle' => $dateActuelle,
            ]);
        }
    }
}
