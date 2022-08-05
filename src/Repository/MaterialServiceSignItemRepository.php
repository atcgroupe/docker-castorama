<?php

namespace App\Repository;

use App\Entity\MaterialServiceSignItem;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method MaterialServiceSignItem|null find($id, $lockMode = null, $lockVersion = null)
 * @method MaterialServiceSignItem|null findOneBy(array $criteria, array $orderBy = null)
 * @method MaterialServiceSignItem[]    findAll()
 * @method MaterialServiceSignItem[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MaterialServiceSignItemRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MaterialServiceSignItem::class);
    }

    // /**
    //  * @return MaterialServiceSignItem[] Returns an array of MaterialServiceSignItem objects
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
    public function findOneBySomeField($value): ?MaterialServiceSignItem
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
