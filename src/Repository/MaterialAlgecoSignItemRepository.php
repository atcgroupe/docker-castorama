<?php

namespace App\Repository;

use App\Entity\MaterialAlgecoSignItem;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method MaterialAlgecoSignItem|null find($id, $lockMode = null, $lockVersion = null)
 * @method MaterialAlgecoSignItem|null findOneBy(array $criteria, array $orderBy = null)
 * @method MaterialAlgecoSignItem[]    findAll()
 * @method MaterialAlgecoSignItem[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MaterialAlgecoSignItemRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MaterialAlgecoSignItem::class);
    }
}
