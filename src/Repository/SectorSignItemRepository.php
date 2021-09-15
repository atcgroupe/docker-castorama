<?php

namespace App\Repository;

use App\Entity\SectorSignItem;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method SectorSignItem|null find($id, $lockMode = null, $lockVersion = null)
 * @method SectorSignItem|null findOneBy(array $criteria, array $orderBy = null)
 * @method SectorSignItem[]    findAll()
 * @method SectorSignItem[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SectorSignItemRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SectorSignItem::class);
    }

    // /**
    //  * @return SectorSignItem[] Returns an array of SectorSignItem objects
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
    public function findOneBySomeField($value): ?SectorSignItem
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
