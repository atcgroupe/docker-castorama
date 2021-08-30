<?php

namespace App\Repository;

use App\Entity\Order;
use App\Entity\OrderStatus;
use App\Entity\Shop;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Order|null find($id, $lockMode = null, $lockVersion = null)
 * @method Order|null findOneBy(array $criteria, array $orderBy = null)
 * @method Order[]    findAll()
 * @method Order[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OrderRepository extends ServiceEntityRepository
{
    public const ITEMS_PER_PAGES = 10;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Order::class);
    }

    public function findWithRelations(bool $isActive, ?User $user = null, ?int $page = null, ?string $search = null)
    {
        $builder = $this->createQueryBuilder('o')
            ->innerJoin('o.user', 'user')
                ->addSelect('user')
            ->innerJoin('user.shop', 'shop')
                ->addSelect('shop')
            ->innerJoin('o.status', 'status')
                ->addSelect('status')
            ->innerJoin('o.member', 'm')
                ->addSelect('m')
        ;

        $this->setActiveFilter($builder, $isActive);

        if (null!== $search) {
            $this->addSearchFilter($builder, $search);
        }

        if (null !== $user) {
            $this->addUserFilter($builder, $user);
        }

        if (null !== $page) {
            $this->setPagination($builder, $page);
        }

        return $builder
            ->orderBy('o.id', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }

    private function setActiveFilter(QueryBuilder $builder, bool $isActive): void
    {
        ($isActive) ? $builder->andWhere('status.label != :label') : $builder->andWhere('status.label = :label');

        $builder->setParameter('label', OrderStatus::DELIVERED);
    }

    private function addUserFilter(QueryBuilder $builder, User $user)
    {
        $builder
            ->andWhere('user.id = :id')
            ->setParameter('id', $user->getId())
        ;
    }

    private function setPagination(QueryBuilder $builder, int $page)
    {
        $firstResult = ( $page - 1 ) * self::ITEMS_PER_PAGES;
        $builder
            ->setFirstResult($firstResult)
            ->setMaxResults(self::ITEMS_PER_PAGES)
        ;
    }

    private function addSearchFilter(QueryBuilder $builder, string $search)
    {
        $builder
            ->andWhere('o.id LIKE :search')
            ->orWhere('o.customerReference LIKE :search')
            ->orWhere('o.title LIKE :search')
                ->setParameter('search', '%' . $search . '%');
    }
}
