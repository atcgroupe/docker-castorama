<?php

namespace App\Repository;

use App\Entity\Order;
use App\Entity\SectorOrderSign;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method SectorOrderSign|null find($id, $lockMode = null, $lockVersion = null)
 * @method SectorOrderSign|null findOneBy(array $criteria, array $orderBy = null)
 * @method SectorOrderSign[]    findAll()
 * @method SectorOrderSign[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SectorOrderSignRepository extends ServiceEntityRepository implements VariableOrderSignRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SectorOrderSign::class);
    }

    public function findByOrderWithRelations(Order $order): array
    {
        return $this->createQueryBuilder('s')
            ->innerJoin('s.item1', 'item1')
                ->addSelect('item1')
            ->leftJoin('s.item2', 'item2')
                ->addSelect('item2')
            ->andWhere('s.order = :order')
                ->setParameter('order', $order)
            ->orderBy('s.id', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * @param Order $order
     */
    public function removeByOrder(Order $order): void
    {
        $this->createQueryBuilder('s')
            ->delete()
            ->where('s.order = :order')
            ->setParameter('order', $order)
            ->getQuery()
            ->getResult();
    }
}
