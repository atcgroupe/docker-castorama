<?php

namespace App\Repository;

use App\Entity\MaterialSectorOrderSign;
use App\Entity\Order;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method MaterialSectorOrderSign|null find($id, $lockMode = null, $lockVersion = null)
 * @method MaterialSectorOrderSign|null findOneBy(array $criteria, array $orderBy = null)
 * @method MaterialSectorOrderSign[]    findAll()
 * @method MaterialSectorOrderSign[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MaterialSectorOrderSignRepository extends ServiceEntityRepository implements OrderSignRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MaterialSectorOrderSign::class);
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
            ->andWhere('m.order = :order')
                ->setParameter('order', $order)
            ->orderBy('m.aisleNumber', 'ASC')
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
