<?php

namespace App\Repository;

use App\Entity\Invitations;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use PDO;

/**
 * @method Invitations|null find($id, $lockMode = null, $lockVersion = null)
 * @method Invitations|null findOneBy(array $criteria, array $orderBy = null)
 * @method Invitations[]    findAll()
 * @method Invitations[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InvitationsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Invitations::class);
    }

    public function findAllBySqlBy($invitationid)
    {
        $sql = "SELECT  s.id as invitid, 
                        consultants.id, 
                        nom, 
                        prenom, 
                        numsecu, 
                        CASe sexe when '1' then 
                            'M' ELSE 
                            'F' 
                        end as sexe, 
                        ddn,
                        s.nbrpersonnes, s.dateinvitation, 
                        type_invitation.libtypeinvitation
                FROM    consultants
                LEFT JOIN invitations_consultants i
                    on i.consultants_id = consultants.id 
                    LEFT JOIN invitations s
                    on s.id = i.invitations_id
                    LEFT JOIN type_invitation
                    ON s.typeinvitation_id = type_invitation.id
                WHERE IFNULL(i.invitations_id,'X') IN ('".$invitationid."','X')";

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

    public function NbrPersInvit($invitationid)
    {
        $sql = "SELECT  count(i.consultants_id) as nbrpersinvites
                FROM    invitations_consultants i
                WHERE IFNULL(i.invitations_id,'X') IN ('".$invitationid."','X')";

        // $params['color'] = 'blue';
        $entityManager = $this->getEntityManager();
        $stmt = $entityManager->getConnection()->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAllAssociative(PDO::FETCH_NUM);
    }

    // /**
    //  * @return Invitations[] Returns an array of Invitations objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('i.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Invitations
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
