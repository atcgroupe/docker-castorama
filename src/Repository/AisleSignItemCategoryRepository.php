<?php

namespace App\Repository;

use App\Entity\AisleSignItemCategory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method AisleSignItemCategory|null find($id, $lockMode = null, $lockVersion = null)
 * @method AisleSignItemCategory|null findOneBy(array $criteria, array $orderBy = null)
 * @method AisleSignItemCategory[]    findAll()
 * @method AisleSignItemCategory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AisleSignItemCategoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AisleSignItemCategory::class);
    }
}
