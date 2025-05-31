<?php

namespace App\Service;

use App\Entity\Vente;
use App\Repository\VenteRepository;
use DateTime;
use Symfony\Component\Security\Core\Authentication\RememberMe\TokenVerifierInterface;

class VenteVerification {
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

    public function verifierVenteFermee(Vente $vente): bool
    {
        $venteFermee = false;
        $dateActuelle = new DateTime('now');
        $dateFinVente = DateTime::createFromFormat('Y-m-d H:i:s', $vente->getDateVente()->format('Y-m-d').$vente->getHeureFin()->format('H:i:s'));
        if($dateActuelle->format('Y-m-d H:i:s') > $dateFinVente->format('Y-m-d H:i:s'))
            $venteFermee = true;
        return $venteFermee;

    }

    public function genererFactures(?Vente $vente): array
    {
        $flash = array();
        if($vente == null) {
            $flash = array('type' => 'danger', 'content' => 'Aucune vente n\'existe à cette date.');
            return $flash;
        }
        if(!$this->verifierVenteFermee($vente)) {
            $flash = array('type' => 'danger', 'content' => 'Vous ne pouvez pas encore générer de factures car cette vente n\'est pas terminée.');
            return $flash;
        }

        $flash = array('type' => 'success', 'content' => 'So far so good');
        return $flash;

    }
}
