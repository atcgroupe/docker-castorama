<?php

namespace App\Repository;

use App\Entity\SignItemCategory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method SignItemCategory|null find($id, $lockMode = null, $lockVersion = null)
 * @method SignItemCategory|null findOneBy(array $criteria, array $orderBy = null)
 * @method SignItemCategory[]    findAll()
 * @method SignItemCategory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SignItemCategoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SignItemCategory::class);
    }

    // /**
    //  * @return SignItemCategory[] Returns an array of SignItemCategory objects
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
    public function findOneBySomeField($value): ?SignItemCategory
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
