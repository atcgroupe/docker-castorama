<?php

namespace App\Repository;

use App\Entity\MaterialAlgecoOrderSign;
use App\Entity\Order;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method MaterialAlgecoOrderSign|null find($id, $lockMode = null, $lockVersion = null)
 * @method MaterialAlgecoOrderSign|null findOneBy(array $criteria, array $orderBy = null)
 * @method MaterialAlgecoOrderSign[]    findAll()
 * @method MaterialAlgecoOrderSign[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MaterialAlgecoOrderSignRepository extends ServiceEntityRepository implements VariableOrderSignRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MaterialAlgecoOrderSign::class);
    }

    public function findByOrderWithRelations(Order $order): array
    {
        return $this->createQueryBuilder('m')
            ->innerJoin('m.item1', 'item1')
                ->addSelect('item1')
            ->leftJoin('m.item2', 'item2')
                ->addSelect('item2')
            ->leftJoin('m.item3', 'item3')
                ->addSelect('item3')
            ->leftJoin('m.item4', 'item4')
                ->addSelect('item4')
            ->andWhere('m.order = :order')
                ->setParameter('order', $order)
            ->orderBy('m.id', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    public function removeByOrder(Order $order): void
    {
        $this->createQueryBuilder('m')
            ->delete()
            ->where('m.order = :order')
                ->setParameter('order', $order)
            ->getQuery()
            ->getResult()
        ;
    }
}
