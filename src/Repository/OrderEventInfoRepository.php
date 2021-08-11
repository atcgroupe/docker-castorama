<?php

namespace App\Repository;

use App\Entity\OrderEventInfo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method OrderEventInfo|null find($id, $lockMode = null, $lockVersion = null)
 * @method OrderEventInfo|null findOneBy(array $criteria, array $orderBy = null)
 * @method OrderEventInfo[]    findAll()
 * @method OrderEventInfo[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OrderEventInfoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OrderEventInfo::class);
    }

    // /**
    //  * @return OrderEventInfo[] Returns an array of OrderEventInfo objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('o.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?OrderEventInfo
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
