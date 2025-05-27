<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Presentation;
use App\Entity\Taille;
use App\Entity\Qualite;
use App\Entity\TypeBateau;
use App\Entity\Bateau;
use App\Entity\Bac;
use App\Entity\Espece;
use App\Entity\Peche;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user->setLogin('admin');
        $user->setEmail('test@test.com');
        $user->setRoles(['ROLE_USER', 'ROLE_ADMIN']);
        $user->setPassword('$2y$13$Y24llt0UhNgB6EjP7684H.hwQz0lBc35EOGpu5anT6htbguA4QaTa'); // hashed password

        $manager->persist($user);
        $manager->flush();

        // Presentation
        $presentations = [];
        $presentationData = [
            [1, 'Entier', 'PR01'],
            [2, 'Ecaillé', 'PR02'],
            [3, 'Evisceré', 'PR03'],
            [4, 'Evisceré étêté', 'PR04'],
            [5, 'Filet', 'PR05'],
        ];
        foreach ($presentationData as [$id, $denomination, $code]) {
            $presentation = new Presentation();
            $presentation->setDenomination($denomination);
            $presentation->setCode($code);
            $manager->persist($presentation);
            $presentations[$id] = $presentation;
        }

        // Taille
        $tailles = [];
        $tailleData = [
            [1, '>3kg'],
            [2, '2-3kg'],
            [3, '1-2kg'],
            [4, '500g-1kg'],
            [5, '<500g'],
        ];
        foreach ($tailleData as [$id, $spec]) {
            $taille = new Taille();
            $taille->setSpecification($spec);
            $manager->persist($taille);
            $tailles[$id] = $taille;
        }

        // Qualite
        $qualites = [];
        $qualiteData = [
            [1, 'Extra frais', 'E'],
            [2, 'A - Très bonne', 'A'],
            [3, 'B - Bonne', 'B'],
            [4, 'Non admis', 'N'],
        ];
        foreach ($qualiteData as [$id, $denomination, $code]) {
            $qualite = new Qualite();
            $qualite->setDenomination($denomination);
            $qualite->setCode($code);
            $manager->persist($qualite);
            $qualites[$id] = $qualite;
        }

        // TypeBateau
        $typeBateaux = [];
        $typeBateauData = [
            [1, 'Fileyeur'],
            [2, 'Ligneur'],
            [3, 'Chalutier côtier'],
        ];
        foreach ($typeBateauData as [$id, $designation]) {
            $typeBateau = new TypeBateau();
            $typeBateau->setDesignation($designation);
            $manager->persist($typeBateau);
            $typeBateaux[$id] = $typeBateau;
        }

        // Bateau
        $bateaux = [];
        $bateauData = [
            [1, 1, 22.5, 'L’Aventure'],
            [2, 2, 18.2, 'Morgane'],
            [3, 1, 25.0, 'Émeraude'],
            [4, 3, 22.7, 'Le Véloce'],
            [5, 1, 26.2, 'Poulgoa-sec'],
            [6, 2, 25.8, 'Merqui-Prendlhomm'],
        ];
        foreach ($bateauData as [$id, $typeBateauId, $tailleBateau, $nomBateau]) {
            $bateau = new Bateau();
            $bateau->setTypeBateau($typeBateaux[$typeBateauId]);
            $bateau->setTailleBateau($tailleBateau);
            $bateau->setNomBateau($nomBateau);
            $manager->persist($bateau);
            $bateaux[$id] = $bateau;
        }

        // Bac
        $bacs = [];
        $bacData = [
            [1, 0.5],
            [2, 1.0],
            [3, 1.5],
            [4, 2.0],
            [5, 2.5],
            [6, 3.0],
        ];
        foreach ($bacData as [$id, $tare]) {
            $bac = new Bac();
            $bac->setTare($tare);
            $manager->persist($bac);
            $bacs[$id] = $bac;
        }

        // Espece
        $especes = [];
        $especeData = [
            [1, 'Lieu jaune', 'Colin', 'Pollachius pollachius'],
            [2, 'Bar', 'Bar européen', 'Dicentrarchus labrax'],
            [3, 'Homard', 'Homard européen', 'Homarus gammarus'],
            [4, 'Turbot', 'Turbot commun', 'Scophthalmus maximus'],
            [5, 'Barbue', 'Barbue commune', 'Scophthalmus rhombus'],
            [6, 'Dorade', 'Dorade royale', 'Sparus aurata'],
            [7, 'Dorade grise', 'Canthare', 'Spondyliosoma cantharus'],
            [8, 'Pagre rouge', 'Pagre commun', 'Sparus pagrus'],
            [9, 'Merlu', 'Merlu commun', 'Merluccius merluccius'],
            [10, 'Saint-Pierre', 'Saint-Pierre', 'Zeus faber'],
            [11, 'Seiche', 'Seiche commune', 'Sepia officinalis'],
        ];
        foreach ($especeData as [$id, $nom, $commun, $scientifique]) {
            $espece = new Espece();
            $espece->setNomEspece($nom);
            $espece->setNomCommunEspece($commun);
            $espece->setNomScientifiqueEspece($scientifique);
            $manager->persist($espece);
            $especes[$id] = $espece;
        }

        // Peche
        $pecheData = [
            [1, '2025-05-12', 15, 1],
            [2, '2025-05-14', 23, 2],
            [3, '2025-05-15', 42, 5],
            [4, '2025-05-11', 11, 4],
            [5, '2025-05-14', 31, 3],
        ];
        foreach ($pecheData as [$id, $date, $duree, $bateauId]) {
            $peche = new Peche();
            $peche->setDatePeche(new \DateTime($date));
            $peche->setDureeMaree($duree);
            $peche->setBateau($bateaux[$bateauId]);
            $manager->persist($peche);
        }

        $manager->flush();
    }
}
