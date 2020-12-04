<?php

namespace App\Repository;

use App\Entity\Medinf;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use PDO;

/**
 * @method Medinf|null find($id, $lockMode = null, $lockVersion = null)
 * @method Medinf|null findOneBy(array $criteria, array $orderBy = null)
 * @method Medinf[]    findAll()
 * @method Medinf[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MedinfRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Medinf::class);
    }

    public function findBySql()
    {
        $sql = "SELECT  Medinf.id, 
                        nom, 
                        prenom, 
                        matricule, 
                        telmedinf, 
                        adresse, 
                        fonction.libfonction,
                        CONCAT(metier.libmetier,' (',metier.codeprofession,')') as metier
                FROM    Medinf
                LEFT JOIN Fonction
                ON      Medinf.fonction_id = fonction.id
                left join medinf_metier m 
                on 		Medinf.id = m.medinf_id 
                    left join metier
                    on metier.id = m.metier_id";

        // $params['color'] = 'blue';
        $entityManager = $this->getEntityManager();
        //create the prepared statement, by getting the doctrine connection
        $stmt = $entityManager->getConnection()->prepare($sql);
        $stmt->execute();
        //I used FETCH_COLUMN because I only needed one Column.
        return $stmt->fetchAllAssociative(PDO::FETCH_COLUMN);
    }
    //  * @return Medinf[] Returns an array of Medinf objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */
    
    /*
    public function findOneBySomeField($value): ?Medinf
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
