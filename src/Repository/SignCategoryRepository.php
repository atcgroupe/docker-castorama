<?php

namespace App\Repository;

use App\Entity\SignCategory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method SignCategory|null find($id, $lockMode = null, $lockVersion = null)
 * @method SignCategory|null findOneBy(array $criteria, array $orderBy = null)
 * @method SignCategory[]    findAll()
 * @method SignCategory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SignCategoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SignCategory::class);
    }

    // /**
    //  * @return SignCategory[] Returns an array of SignCategory objects
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
    public function findOneBySomeField($value): ?SignCategory
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
