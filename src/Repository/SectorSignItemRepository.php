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
}
