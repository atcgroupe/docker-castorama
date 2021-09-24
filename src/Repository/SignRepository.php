<?php

namespace App\Repository;

use App\Entity\Sign;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Sign|null find($id, $lockMode = null, $lockVersion = null)
 * @method Sign|null findOneBy(array $criteria, array $orderBy = null)
 * @method Sign[]    findAll()
 * @method Sign[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SignRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Sign::class);
    }
}
