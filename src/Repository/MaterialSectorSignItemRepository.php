<?php

namespace App\Repository;

use App\Entity\MaterialSectorSignItem;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method MaterialSectorSignItem|null find($id, $lockMode = null, $lockVersion = null)
 * @method MaterialSectorSignItem|null findOneBy(array $criteria, array $orderBy = null)
 * @method MaterialSectorSignItem[]    findAll()
 * @method MaterialSectorSignItem[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MaterialSectorSignItemRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MaterialSectorSignItem::class);
    }
}
