<?php

namespace App\Repository;

use App\Entity\CustomOrderSign;
use App\Entity\Order;
use App\Entity\Sign;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CustomOrderSign|null find($id, $lockMode = null, $lockVersion = null)
 * @method CustomOrderSign|null findOneBy(array $criteria, array $orderBy = null)
 * @method CustomOrderSign[]    findAll()
 * @method CustomOrderSign[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CustomOrderSignRepository extends ServiceEntityRepository implements CustomOrderSignRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CustomOrderSign::class);
    }

    /**
     * @param Order $order
     * @param Sign $sign
     * @return CustomOrderSign[]
     */
    public function findByOrderWithRelations(Order $order, Sign $sign): array
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.order = :order')
                ->setParameter('order', $order)
            ->andWhere('c.sign = :sign')
                ->setParameter('sign', $sign)
            ->innerJoin('c.sign', 'sign')
                ->addSelect('sign')
            ->orderBy('sign.name', 'ASC')
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
            ->getResult()
        ;
    }
}
