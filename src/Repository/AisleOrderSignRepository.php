<?php

namespace App\Repository;

use App\Entity\AisleOrderSign;
use App\Entity\Order;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method AisleOrderSign|null find($id, $lockMode = null, $lockVersion = null)
 * @method AisleOrderSign|null findOneBy(array $criteria, array $orderBy = null)
 * @method AisleOrderSign[]    findAll()
 * @method AisleOrderSign[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AisleOrderSignRepository extends ServiceEntityRepository implements OrderSignRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AisleOrderSign::class);
    }

    /**
     * @param Order $order
     *
     * @return AisleOrderSign[]
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
