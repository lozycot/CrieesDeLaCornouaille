<?php

namespace App\Service;

use App\Entity\Vente;
use App\Repository\VenteRepository;
use App\Entity\Lot;
use App\Repository\LotRepository;
use App\Entity\Facture;
use App\Repository\FactureRepository;
use Doctrine\ORM\EntityManagerInterface;
use DateTime;
use Symfony\Component\Security\Core\Authentication\RememberMe\TokenVerifierInterface;

class VenteVerification {
    private FactureRepository $factureRepository;
    private EntityManagerInterface $manager;

    public function __construct(FactureRepository $factureRepository, EntityManagerInterface $manager)
    {
        $this->factureRepository = $factureRepository;
        $this->manager = $manager;
    }

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

    /**
     * Vérifie si une vente est fermée (pour savoir si on peut générer les factures).
     * @param Vente $vente
     * */
    private function verifierVenteFermee(Vente $vente): bool
    {
        $venteFermee = false;
        $dateActuelle = new DateTime('now');
        $dateFinVente = DateTime::createFromFormat('Y-m-d H:i:s', $vente->getDateVente()->format('Y-m-d').$vente->getHeureFin()->format('H:i:s'));
        if($dateActuelle->format('Y-m-d H:i:s') > $dateFinVente->format('Y-m-d H:i:s'))
            $venteFermee = true;
        return $venteFermee;

    }

    /**
     * Génère les factures d'une vente donnée et les ajoutes dans la base de données.
     * Retourne un tableau de messages flash qui est un tableau de tableaux associatifs
     * arrays contenant les clés `type` pour le type de message flash et `content` pour
     * le contenu.
     * @param Vente $vente
     * @return array
     * */
    public function genererFactures(?Vente $vente): array
    {
        $flash = [];
        if($vente == null) {
            $flash[] = array('type' => 'danger', 'content' => 'Aucune vente n\'existe à cette date.');
            return $flash;
        }
        if(!$this->verifierVenteFermee($vente)) {
            $flash[] = array('type' => 'danger', 'content' => 'Vous ne pouvez pas encore générer de factures car cette vente n\'est pas terminée.');
            return $flash;
        }

        $lots = $vente->getLots();
        $encheresLesPlusHautes = [];

        // nombre de factures déjà existantes
        $nbFacturesDejaExistantes = 0;
        $nbFacturesGenerees = 0;
        // nombre d'enchères nouvellement ajoutées à des factures
        $nbEncheresAjoutees = 0;

        // agir sur chaque lot de la vente
        foreach($lots as $lot) {
            $encheresLot = $lot->getEncheres();
            $prixMax = 0;

            // trouver l'enchère la plus haute
            $enchereLaPlusHaute = null;
            foreach($encheresLot as $enchere) {
                if($enchere->getPrixEnchere() > $prixMax) {
                    $prixMax = $enchere->getPrixEnchere();
                    $enchereLaPlusHaute = $enchere;
                }
            }

            $encheresLesPlusHautes[] = $enchereLaPlusHaute;

            // vérifier qu'une facture n'existe pas déjà pour ce lot
            $factureExiste = false;
            foreach($lot->getEncheres() as $e) {
                if($e->getFacture() != null) {
                    $factureExiste = true;
                    $nbFacturesDejaExistantes++;
                }
            }
            // si il n'y a pas déjà de facture pour ce lot
            if(!$factureExiste) {
                $acheteurDeLenchere = $enchereLaPlusHaute->getAcheteur();
                $facture = $this->factureRepository->findOneBy(array(
                    'acheteur' => $acheteurDeLenchere->getId(),
                    'vente' => $vente->getId()
                ));

                // si la facture n'existe pas encore, alors en créer une nouvelle
                if($facture == null) {
                    $facture = new Facture();
                    $facture->setAcheteur($acheteurDeLenchere);
                    $facture->setVente($vente);
                    $facture->setPayee(false);
                    $nbFacturesGenerees++;
                }

                // ajouter dans la BDD
                $facture->addEnchere($enchereLaPlusHaute);
                $nbEncheresAjoutees++;
                $this->manager->persist($facture);
                $this->manager->flush();
            }
        }

        // créer les messages flash
        if ($nbFacturesDejaExistantes > 0) {
            $flash[] = array('type' => 'warning', 'content' => $nbFacturesDejaExistantes.' lots possédaient déjà une facture et n\'ont pas été modifiés.');
        }
        $flash[] = array('type' => 'info', 'content' => $nbFacturesGenerees.' nouvelles factures créées et '.$nbEncheresAjoutees.' enchères ajoutées aux factures.');

        return $flash;
    }
}
