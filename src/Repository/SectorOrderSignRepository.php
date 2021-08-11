<?php

namespace App\Repository;

use App\Entity\SectorOrderSign;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method SectorOrderSign|null find($id, $lockMode = null, $lockVersion = null)
 * @method SectorOrderSign|null findOneBy(array $criteria, array $orderBy = null)
 * @method SectorOrderSign[]    findAll()
 * @method SectorOrderSign[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SectorOrderSignRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SectorOrderSign::class);
    }

    // /**
    //  * @return SectorOrderSign[] Returns an array of SectorOrderSign objects
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
    public function findOneBySomeField($value): ?SectorOrderSign
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
