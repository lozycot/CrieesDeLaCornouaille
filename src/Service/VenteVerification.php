<?php

namespace App\Service;

use App\Entity\Vente;
use DateTime;

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
}
