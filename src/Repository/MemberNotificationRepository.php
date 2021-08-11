<?php

namespace App\Repository;

use App\Entity\MemberNotification;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method MemberNotification|null find($id, $lockMode = null, $lockVersion = null)
 * @method MemberNotification|null findOneBy(array $criteria, array $orderBy = null)
 * @method MemberNotification[]    findAll()
 * @method MemberNotification[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MemberNotificationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MemberNotification::class);
    }

    // /**
    //  * @return MemberNotification[] Returns an array of MemberNotification objects
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
    public function findOneBySomeField($value): ?MemberNotification
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
