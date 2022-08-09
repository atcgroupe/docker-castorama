<?php

namespace App\Repository;

use App\Entity\MaterialDirOrderSign;
use App\Entity\Order;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method MaterialDirOrderSign|null find($id, $lockMode = null, $lockVersion = null)
 * @method MaterialDirOrderSign|null findOneBy(array $criteria, array $orderBy = null)
 * @method MaterialDirOrderSign[]    findAll()
 * @method MaterialDirOrderSign[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MaterialDirOrderSignRepository extends ServiceEntityRepository implements VariableOrderSignRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MaterialDirOrderSign::class);
    }

    public function findByOrderWithRelations(Order $order): array
    {
        return $this->createQueryBuilder('m')
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
