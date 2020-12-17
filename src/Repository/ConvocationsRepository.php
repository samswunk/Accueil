<?php

namespace App\Repository;

use App\Entity\Convocations;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use PDO;

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

    public function findAllBySqlBy($convocationid)
    {
        $sql = "SELECT  s.id as idconvo,
                        consultants.id,
                        nom,
                        prenom,
                        numsecu,
                        CASe sexe when '1' then
                            'M' ELSE
                            'F'
                        end as sexe,
                        ddn,
                        s.nbrpersonnes, s.dateconvocation
                FROM consultants
                LEFT JOIN convocations s
                    on s.nti_id = consultants.id
                WHERE IFNULL(s.id,'X') IN ('".$convocationid."','X')";

        //set parameters 
        //you may set as many parameters as you have on your query
        // $params['color'] = 'blue';
        $entityManager = $this->getEntityManager();
        //create the prepared statement, by getting the doctrine connection
        $stmt = $entityManager->getConnection()->prepare($sql);
        $stmt->execute();
        //I used FETCH_COLUMN because I only needed one Column.
        return $stmt->fetchAllAssociative(PDO::FETCH_ASSOC);
    }

    public function NbrPersConvoc($convocationid)
    {
        $sql = "SELECT  count(nti_id) as nbrpersconvoquees
                FROM    convocations
                WHERE IFNULL(id,'X') IN ('".$convocationid."','X')";

        // $params['color'] = 'blue';
        $entityManager = $this->getEntityManager();
        $stmt = $entityManager->getConnection()->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAllAssociative(PDO::FETCH_NUM);
    }
}
