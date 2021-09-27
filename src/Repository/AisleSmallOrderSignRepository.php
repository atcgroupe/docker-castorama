<?php

namespace App\Repository;

use App\Entity\AisleSmallOrderSign;
use App\Entity\Order;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method AisleSmallOrderSign|null find($id, $lockMode = null, $lockVersion = null)
 * @method AisleSmallOrderSign|null findOneBy(array $criteria, array $orderBy = null)
 * @method AisleSmallOrderSign[]    findAll()
 * @method AisleSmallOrderSign[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AisleSmallOrderSignRepository extends ServiceEntityRepository implements OrderSignRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AisleSmallOrderSign::class);
    }

    /**
     * @param Order $order
     *
     * @return AisleSmallOrderSign[]
     */
    public function findByOrderWithRelations(Order $order): array
    {
        return $this->createQueryBuilder('a')
            ->innerJoin('a.item1', 'item1')
                ->addSelect('item1')
            ->leftJoin('a.item2', 'item2')
                ->addSelect('item2')
            ->leftJoin('a.item3', 'item3')
                ->addSelect('item3')
            ->andWhere('a.order = :order')
                ->setParameter('order', $order)
            ->orderBy('a.aisleNumber', 'ASC')
            ->getQuery()
            ->getResult()
            ;
    }
}
