<?php

namespace App\Repository;

use App\Entity\FixedOrderSign;
use App\Entity\Order;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method FixedOrderSign|null find($id, $lockMode = null, $lockVersion = null)
 * @method FixedOrderSign|null findOneBy(array $criteria, array $orderBy = null)
 * @method FixedOrderSign[]    findAll()
 * @method FixedOrderSign[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FixedOrderSignRepository extends ServiceEntityRepository implements OrderSignRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FixedOrderSign::class);
    }

    /**
     * @param Order $order
     *
     * @return FixedOrderSign[]
     */
    public function findByOrderWithRelations(Order $order): array
    {
        return $this->createQueryBuilder('a')
            ->innerJoin('a.fixedSign', 'fixedSign')
                ->addSelect('fixedSign')
            ->andWhere('a.order = :order')
                ->setParameter('order', $order)
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * @param Order $order
     * @param int $category
     * @return FixedOrderSign[]
     */
    public function findByOrderAndCategoryWithRelations(Order $order, int $category): array
    {
        return $this->createQueryBuilder('a')
            ->innerJoin('a.fixedSign', 'fixedSign')
                ->addSelect('fixedSign')
            ->andWhere('a.order = :order')
                ->setParameter('order', $order)
            ->andWhere('fixedSign.category = :category')
                ->setParameter('category', $category)
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * @param Order $order
     */
    public function removeByOrder(Order $order): void
    {
        $this->createQueryBuilder('a')
            ->delete()
            ->where('a.order = :order')
                ->setParameter('order', $order)
            ->getQuery()
            ->getResult();
    }
}
