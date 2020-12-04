<?php

namespace App\Repository;

use App\Entity\Convocations;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Convocations|null find($id, $lockMode = null, $lockVersion = null)
 * @method Convocations|null findOneBy(array $criteria, array $orderBy = null)
 * @method Convocations[]    findAll()
 * @method Convocations[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ConvocationsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Convocations::class);
    }

    // /**
    //  * @return Convocations[] Returns an array of Convocations objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Convocations
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
