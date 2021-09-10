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
class SectorOrderSignRepository extends ServiceEntityRepository implements OrderSignRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SectorOrderSign::class);
    }

    public function findByOrderWithRelations(Order $order): array
    {
        return $this->createQueryBuilder('s')
            ->innerJoin('s.itemOne', 'itemOne')
                ->addSelect('itemTwo')
            ->innerJoin('s.itemTwo', 'itemTwo')
                ->addSelect('itemTwo')
            ->andWhere('s.order = :order')
                ->setParameter('order', $order)
            ->orderBy('s.id', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }
}
