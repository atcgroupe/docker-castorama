<?php

namespace App\Repository;

use App\Entity\AisleOrderSign;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method AisleOrderSign|null find($id, $lockMode = null, $lockVersion = null)
 * @method AisleOrderSign|null findOneBy(array $criteria, array $orderBy = null)
 * @method AisleOrderSign[]    findAll()
 * @method AisleOrderSign[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AisleOrderSignRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AisleOrderSign::class);
    }

    // /**
    //  * @return AisleOrderSign[] Returns an array of AisleOrderSign objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?AisleOrderSign
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
