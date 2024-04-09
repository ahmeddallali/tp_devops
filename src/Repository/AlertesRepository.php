<?php

namespace App\Repository;

use App\Entity\Alertes;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Alertes|null find($id, $lockMode = null, $lockVersion = null)
 * @method Alertes|null findOneBy(array $criteria, array $orderBy = null)
 * @method Alertes[]    findAll()
 * @method Alertes[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AlertesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Alertes::class);
    }

    // /**
    //  * @return Alertes[] Returns an array of Alertes objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Alertes
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
