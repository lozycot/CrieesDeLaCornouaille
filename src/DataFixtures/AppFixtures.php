<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Acheteur;
use App\Entity\Presentation;
use App\Entity\Taille;
use App\Entity\Qualite;
use App\Entity\TypeBateau;
use App\Entity\Bateau;
use App\Entity\Bac;
use App\Entity\Enchere;
use App\Entity\Espece;
use App\Entity\Peche;
use App\Entity\Vente;
use App\Entity\Lot;
use DateTime;
use DateInterval;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private UserPasswordHasherInterface $userPasswordHasher;

    public function __construct (UserPasswordHasherInterface $userPasswordHasher)
    {
        $this->userPasswordHasher = $userPasswordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        /*
         * UTILISATEURS
         */
        $acheteurs = [];

        $user = new User();
        $user->setLogin('admin');
        $user->setEmail('test@test.com');
        $user->setRoles(['ROLE_USER', 'ROLE_ADMIN', 'ROLE_COMPTA']);
        $user->setPassword('$2y$13$Y24llt0UhNgB6EjP7684H.hwQz0lBc35EOGpu5anT6htbguA4QaTa'); // hashed password
        $manager->persist($user);
        $manager->flush();

        $comptable = new User();
        $comptable->setLogin('comptable');
        $comptable->setEmail('compta@criee-cornouaille.fr');
        $comptable->setRoles(['ROLE_COMPTA']);
        $comptable->setPassword($this->userPasswordHasher->hashPassword($comptable, 'comptable123!'));
        $manager->persist($comptable);
        $manager->flush();

        $user1 = new User();
        $user1->setLogin('acheteur1');
        $user1->setEmail('acheteur1@test.com');
        $user1->setRoles(['ROLE_USER', 'ROLE_ACHETEUR']);
        $user1->setPassword($this->userPasswordHasher->hashPassword($user1, 'acheteur123!'));


        $manager->persist($user1);
        $manager->flush();

        $acheteur1 = new Acheteur();
        $acheteur1->setCodePostal('67000');
        $acheteur1->setNumHabilitation('5654');
        $acheteur1->setNumRue('26');
        $acheteur1->setRaisonSocialeEntreprise('SARL ACHETEUR 1');
        $acheteur1->setRue('Rue Schoch');
        $acheteur1->setUser($user1);
        $acheteur1->setVille('STRASBOURG');

        $manager->persist($acheteur1);
        $manager->flush();
        $acheteurs[] = $acheteur1;

        $user2 = new User();
        $user2->setLogin('acheteur2');
        $user2->setEmail('acheteur2@test.com');
        $user2->setRoles(['ROLE_USER', 'ROLE_ACHETEUR']);
        $user2->setPassword($this->userPasswordHasher->hashPassword($user2, 'acheteur123!'));

        $manager->persist($user2);
        $manager->flush();

        $acheteur2 = new Acheteur();
        $acheteur2->setCodePostal('56000');
        $acheteur2->setNumHabilitation('55654');
        $acheteur2->setNumRue('75');
        $acheteur2->setRaisonSocialeEntreprise('SARL LA POISSCAILLE');
        $acheteur2->setRue('Rue du port');
        $acheteur2->setUser($user2);
        $acheteur2->setVille('SARZEAU');

        $manager->persist($acheteur2);
        $manager->flush();
        $acheteurs[] = $acheteur2;

        $user3 = new User();
        $user3->setLogin('acheteur3');
        $user3->setEmail('acheteur3@test.com');
        $user3->setRoles(['ROLE_USER', 'ROLE_ACHETEUR']);
        $user3->setPassword($this->userPasswordHasher->hashPassword($user3, 'acheteur123!'));

        $manager->persist($user3);
        $manager->flush();

        $acheteur3 = new Acheteur();
        $acheteur3->setCodePostal('56000');
        $acheteur3->setNumHabilitation('56554');
        $acheteur3->setNumRue('41');
        $acheteur3->setRaisonSocialeEntreprise('SARL LE PENNEC');
        $acheteur3->setRue('Rue de la mer');
        $acheteur3->setUser($user3);
        $acheteur3->setVille('ST-ARMEL');

        $manager->persist($acheteur3);
        $manager->flush();
        $acheteurs[] = $acheteur3;

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
        $peches = [];
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
            $peches[$id] = $peche;
        }

        // // Add 5 ventes with today's date, heureDebut/heureFin as described
        // $today = new \DateTimeImmutable('today');
        // $now = new \DateTime();
        // // Round up to the next half hour
        // $minute = (int)$now->format('i');
        // $second = (int)$now->format('s');
        // if ($minute === 0 && $second === 0) {
        //     $nextHalfHour = (clone $now)->setTime((int)$now->format('H'), 0, 0);
        // } elseif ($minute < 30) {
        //     $nextHalfHour = (clone $now)->setTime((int)$now->format('H'), 30, 0);
        // } else {
        //     $nextHalfHour = (clone $now)->modify('+1 hour')->setTime((int)$now->format('H') + 1, 0, 0);
        // }

        // Créer 5 ventes à 1 jour d'intervalle à partir d'avant hier
        $laDate = new DateTimeImmutable('now - 2 day');
        $ventesArray = [];
        $heureDebut = new DateTime('06:00:00');
        $heureFin = new DateTime('16:00:00');
        for ($i = 0; $i < 5; $i++) {
            $vente = new Vente();
            $vente->setDateVente(DateTime::createFromImmutable($laDate));
            $vente->setHeureDebut($heureDebut);
            $vente->setHeureFin($heureFin);
            $manager->persist($vente);
            $ventesArray[] = $vente;
            $interval = DateInterval::createFromDateString('1 day');
            $laDate = $laDate->add($interval);
        }

        // Create 3 to 7 lots for each vente
        foreach ($ventesArray as $vente) {
            // $nbLots = random_int(3, 7);
            $nbLots = 5;
            for ($i = 0; $i < $nbLots; $i++) {
                $lot = new Lot();
                $lot->setPrixPlancher(mt_rand(100, 300) / 10); // 10.0 - 30.0

                // Générer un prix au Kg et un poids, puis calculer le prix de départ
                $prixAuKg = mt_rand(20, 120) / 10; // 2.0 - 12.0
                $poids = mt_rand(4, 40); // 4 - 40 Kg
                $prixDepart = $prixAuKg * $poids;
                $lot->setPrixDepart($prixDepart);

                $lot->setPrixEncheresMax($lot->getPrixDepart() + 100); // 20.0 - 50.0

                // Heure d'ouverture enchère: répartir sur l'heure de la vente
                // $minutes = (int)($i * (60 / $nbLots));
                $heures = $i * 2;
                $heureDebutEnchere = (clone $vente->getHeureDebut())->modify("+$heures hours");
                $lot->setHeureDebutEnchere($heureDebutEnchere);
                $lot->setVente($vente);
                $lot->setCodeEtat('OK');
                $lot->setPoidsBrutLot($poids);
                $lot->setQualite($qualites[array_rand($qualites)]);
                $lot->setBac($bacs[array_rand($bacs)]);
                $lot->setPresentation($presentations[array_rand($presentations)]);
                $lot->setTaille($tailles[array_rand($tailles)]);
                $lot->setEspece($especes[array_rand($especes)]);
                // Assign a random Peche to each lot
                $lot->setPeche($peches[array_rand($peches)]);
                $manager->persist($lot);

                // ajouter des enchères
                $nbEncheres = 3;
                $prixEnchere = $lot->getPrixDepart() + 10;
                for($j = 0; $j < $nbEncheres; $j++) {
                    $enchere = new Enchere();

                    // choisir un acheteur au hasard
                    $acheteur = $acheteurs[array_rand($acheteurs)];
                    $minutes = $j * 10 + 10;
                    $enchere->setAcheteur($acheteur);
                    $enchere->setLot($lot);
                    $enchere->setHeureEnchere((clone $lot->getHeureDebutEnchere())->modify("+$minutes minutes"));
                    $enchere->setPrixEnchere($prixEnchere);
                    $manager->persist($enchere);
                    $manager->flush();
                    
                    $prixEnchere += 10;
                }
            }
        }

        $manager->flush();
    }
}
