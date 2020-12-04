<?php

namespace App\Repository;

use App\Entity\Consultants;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManager as ORMEntityManager;
use Doctrine\ORM\EntityManagerInterface as EntityManager;
use Doctrine\ORM\Query\ResultSetMapping;
use Doctrine\Persistence\ManagerRegistry;
use PDO;

/**
 * @method Consultants|null find($id, $lockMode = null, $lockVersion = null)
 * @method Consultants|null findOneBy(array $criteria, array $orderBy = null)
 * @method Consultants[]    findAll()
 * @method Consultants[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ConsultantsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Consultants::class);
    }

    /**
     * @return Consultants[] Returns an array of Consultants objects
    */
    
    public function findAllBySql()
    {
        /* METHODE 1 */
        //Place query here, let's say you want all the users that have blue as their favorite color
        $sql = "SELECT  Consultants.id, 
                        nom, 
                        prenom, 
                        numsecu, 
                        CASe sexe when '1' then 
                            'M' ELSE 
                            'F' 
                        end as sexe, 
                        ddn, Convocations.nbrpersonnes, convocations.dateconvocation
                FROM    Consultants
                LEFT JOIN Convocations
                ON      Consultants.id = Convocations.nti_id";

        //set parameters 
        //you may set as many parameters as you have on your query
        
        // $params['color'] = 'blue';
        $entityManager = $this->getEntityManager();
        //create the prepared statement, by getting the doctrine connection
        $stmt = $entityManager->getConnection()->prepare($sql);
        $stmt->execute();
        //I used FETCH_COLUMN because I only needed one Column.
        return $stmt->fetchAllAssociative(PDO::FETCH_COLUMN);
        // /*--------------------------------------------------*/
        // $manager = $this->getDoctrine()->getManager();
        // $conn = $manager->getConnection();

        // $result= $conn->query('select foobar from mytable')->fetchAll();

        // $this->appendStringToFile("first row foobar is: " . $result[0]['foobar']);

        // return $result;
        // $conn               = $this->entityManager->getConnection();
        // $statement          = $conn->query('select foo from bar');
        // $num_rows_effected  = $conn->exec('update bar set foo=1');

        // return $this->createQueryBuilder('c')
        //     ->andWhere('c.exampleField = :val')
        //     ->setParameter('val', $value)
        //     ->orderBy('c.id', 'ASC')
        //     ->setMaxResults(10)
        //     ->getQuery()
        //     ->getResult()
        // ;
    }
    
    // /**
    //  * @return Consultants[] Returns an array of Consultants objects
    //  */
    
    public function findAllBySql2($value)
    {
        $rsm = new ResultSetMapping();
        // build rsm here

        $query = $this->entityManager->createNativeQuery('SELECT id, endant_id, nom, prenom, numsecu, sexe, ddn FROM Consultants'); // WHERE name = ?', $rsm);
        // $query->setParameter(1, 'romanb');

        $consultants = $query->getResult();

        return $consultants;
    }
    // /**
    //  * @return Consultants[] Returns an array of Consultants objects
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
    public function findOneBySomeField($value): ?Consultants
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
