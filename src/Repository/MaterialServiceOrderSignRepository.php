<?php

namespace App\Repository;

use App\Entity\MaterialServiceOrderSign;
use App\Entity\Order;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method MaterialServiceOrderSign|null find($id, $lockMode = null, $lockVersion = null)
 * @method MaterialServiceOrderSign|null findOneBy(array $criteria, array $orderBy = null)
 * @method MaterialServiceOrderSign[]    findAll()
 * @method MaterialServiceOrderSign[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MaterialServiceOrderSignRepository extends ServiceEntityRepository implements VariableOrderSignRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MaterialServiceOrderSign::class);
    }

    public function findByOrderWithRelations(Order $order): array
    {
        return $this->createQueryBuilder('m')
            ->innerJoin('m.item1', 'item1')
                ->addSelect('item1')
            ->leftJoin('m.item2', 'item2')
                ->addSelect('item2')
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
