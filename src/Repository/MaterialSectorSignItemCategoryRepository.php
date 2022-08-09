<?php

namespace App\Repository;

use App\Entity\MaterialSectorSignItemCategory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method MaterialSectorSignItemCategory|null find($id, $lockMode = null, $lockVersion = null)
 * @method MaterialSectorSignItemCategory|null findOneBy(array $criteria, array $orderBy = null)
 * @method MaterialSectorSignItemCategory[]    findAll()
 * @method MaterialSectorSignItemCategory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MaterialSectorSignItemCategoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MaterialSectorSignItemCategory::class);
    }
}
