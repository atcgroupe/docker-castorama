<?php

namespace App\Repository;

use App\Entity\AisleSignItem;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method AisleSignItem|null find($id, $lockMode = null, $lockVersion = null)
 * @method AisleSignItem|null findOneBy(array $criteria, array $orderBy = null)
 * @method AisleSignItem[]    findAll()
 * @method AisleSignItem[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AisleSignItemRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AisleSignItem::class);
    }

    // /**
    //  * @return SignItem[] Returns an array of SignItem objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?SignItem
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
