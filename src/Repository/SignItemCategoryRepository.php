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

    /**
     * @param string $class
     *
     * @return SignItemCategory[]
     */
    public function findBySignClass(string $class): array
    {
        return $this->createQueryBuilder('signItemCategory')
            ->leftJoin('signItemCategory.sign', 'sign')
            ->andWhere('sign.class = :class')
                ->setParameter('class', $class)
            ->orderBy('signItemCategory.id', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }
}
