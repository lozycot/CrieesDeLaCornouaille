<?php

namespace App\Controller;

use App\Entity\Enchere;
use App\Form\EnchereType;
use App\Repository\AcheteurRepository;
use App\Service\VenteVerification;
use App\Repository\LotRepository;
use App\Repository\VenteRepository;
use App\Repository\EnchereRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;
use DateTime;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\Time;

#[Route('/acheteur/enchere')]
final class EnchereController extends AbstractController
{
    #[Route('', name: 'app_acheteur_enchere')]
    public function index(
        ?LotRepository $lotRepo,
        ?VenteRepository $venteRepo,
        ?EnchereRepository $enchereRepo,
        ?AcheteurRepository $acheteurRepo,
        VenteVerification $venteVerification,
        EntityManagerInterface $manager,
        Request $request
    ): Response
    {
        $dateActuelle = new DateTime("now");
        $vente = $venteRepo->findProchaineVente();
        $venteEstOuverte = $venteVerification->venteEstOuverte($vente);

        // si la vente n'est pas ouverte, retourner sur la page Vente
        if(!$venteEstOuverte) {
            $this->addFlash('error', 'Aucune vente actuellement ouverte.');
            return $this->redirectToRoute("app_vente");
        } else { // sinon aller sur la page enchères

            
            // récupérer les lots
            $lots = $lotRepo->findByDateVente($dateActuelle);

            // chercher le lot actuellement ouvert à la vente, si il y en a un
            $lotActuel = null;
            $indexLotSuivant = 0;
            $heureFinEnchere = date_create('00:00:00');
            foreach($lots as $unLot) {
                if($unLot->getHeureDebutEnchere()->format('H:i:s') <= $dateActuelle->format('H:i:s')){
                    $lotActuel = $unLot;
                    $indexLotSuivant++;
                }
            }
            // trouver l'heure de fin de l'enchère
            if($indexLotSuivant < sizeof($lots) - 1){
                $indexLotSuivant++;
                $heureFinEnchere = $lots[$indexLotSuivant]->getHeureDebutEnchere();
            } else {
                $heureFinEnchere = $vente->getHeureFin();
            }
            
            // trouver les enchères pour ce lot
            $encheres = null;
            if($lotActuel != null) {
                $encheres = $enchereRepo->findBy(array("lot" => $lotActuel), array('prixEnchere' => 'ASC'));
            }

            // trouver l'enchère la plus haute
            $enchereLaPlusHaute = 0;
            foreach($encheres as $e) {
                if($e->getPrixEnchere() > $enchereLaPlusHaute) {
                    $enchereLaPlusHaute = $e->getPrixEnchere();
                }
            }

            // création du nouvel objet enchère + du formulaire
            $newEnchere = new Enchere();
            // assigner le lot actuellement à la vente
            if($newEnchere->getLot() == null)
                $newEnchere->setLot($lotActuel);
            $form = $this->createForm(EnchereType::class, $newEnchere);

            // Enregistrement des données
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $acheteur = $acheteurRepo->findOneBy(array('user' => $this->getUser()));
                if($acheteur == null) {
                    $this->addFlash('danger', 'Erreur : vous n\'êtes pas un acheteur ou les données d\'acheteur n\'ont pas été renseignées. Annulation.');
                } elseif($newEnchere->getPrixEnchere() <= $enchereLaPlusHaute) {
                    $this->addFlash('danger', 'Erreur : une enchère plus haute a déjà été réalisée. Annulation de votre enchère.');
                } elseif($newEnchere->getLot() != $lotActuel) {
                    $this->addFlash('danger', 'Erreur : le lot n°'.$newEnchere->getLot()->getId().' n\'est plus enchèrissable. Annulation de votre enchère.');
                } else {
                    $newEnchere->setAcheteur($acheteur);
                    // message de succès
                    $this->addFlash('success', 'L\'enchère a bien été effectuée.');
                    $manager->persist($newEnchere);
                    // écrire dans la base de données :
                    $manager->flush();
                }
                
                return $this->redirectToRoute('app_acheteur_enchere');
            }

            return $this->render('acheteur/enchere/index.html.twig', [
                'controller_name' => 'EnchereController',
                'lots' => $lots,
                'dateActuelle' => $dateActuelle,
                'idLotActuel' => $lotActuel->getId(),
                'form' => $form,
                'encheres' => $encheres,
                'enchereLaPlusHaute' => $enchereLaPlusHaute,
            ]);
        }
    }
}
