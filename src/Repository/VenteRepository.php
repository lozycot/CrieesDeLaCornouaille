<?php

namespace App\Repository;

use App\Entity\Vente;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use DateTime;

/**
 * @extends ServiceEntityRepository<Vente>
 */
class VenteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Vente::class);
    }

    //    /**
    //     * @return Vente[] Returns an array of Vente objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('v')
    //            ->andWhere('v.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('v.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    /**
     * Retourne soit la vente actuelle, si elle existe, soit la prochaine vente à ouvrir.
     * */
    public function findProchaineVente(): ?Vente
    {
        return $this->createQueryBuilder('v')
            // SELECT * FROM vente WHERE (dateVente = CURRENT_DATE() AND heureFin > CURRENT_TIME) OR
            // dateVente > CURRENT_DATE() ORDER BY dateVente LIMIT 1;
            //
            // Explication : sélectionne la vente dont la date est celle d'aujourd'hui, si l'heure de fin n'est pas dépassée,
            // sinon sélectionne la prochaine vente à ouvrir (dont la date est supérieure à celle d'aujourd'hui). Ordonner
            // le résultat de la date la plus tôt à la date la plus tard et ne garder que le premier résultat.
            ->Where(array('v.dateVente = CURRENT_DATE()', "v.heureFin > CURRENT_TIME()"))
            ->orWhere('v.dateVente > CURRENT_DATE()')
            ->orderBy('v.dateVente')
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    //    public function findOneBySomeField($value): ?Vente
    //    {
    //        return $this->createQueryBuilder('v')
    //            ->andWhere('v.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
