<?php

namespace App\Repository;

use App\Entity\Order;
use App\Entity\OrderStatus;
use App\Entity\Shop;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
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

    /**
     * @param int $id
     *
     * @return Order|null
     * @throws NonUniqueResultException
     */
    public function findOneWithRelations(int $id): Order | null
    {
        return $this->getBaseQueryBuilder()
            ->andWhere('o.id = :id')
                ->setParameter('id', $id)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    /**
     * @param bool        $isActive
     * @param bool        $isCustomerUser
     * @param User|null   $user
     * @param int|null    $page
     * @param string|null $search
     *
     * @return Order[]|[]
     */
    public function findWithRelations(
        bool    $isActive,
        bool    $isCustomerUser,
        ?User   $user = null,
        ?int    $page = null,
        ?string $search = null
    ): array {
        $builder = $this->getBaseQueryBuilder();

        $this->setStatusFilter($builder, $isActive, $isCustomerUser);

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

    /**
     * @return QueryBuilder
     */
    private function getBaseQueryBuilder(): QueryBuilder
    {
        return $this->createQueryBuilder('o')
            ->innerJoin('o.user', 'user')
                ->addSelect('user')
            ->innerJoin('user.shop', 'shop')
                ->addSelect('shop')
            ->innerJoin('o.status', 'status')
                ->addSelect('status')
            ->leftJoin('o.member', 'm')
                ->addSelect('m')
        ;
    }

    /**
     * @param QueryBuilder $builder
     * @param bool         $isActive
     * @param bool         $isCustomerUser
     */
    private function setStatusFilter(QueryBuilder $builder, bool $isActive, bool $isCustomerUser): void
    {
        // active orders has all status except Delivered
        ($isActive) ?
            $builder->andWhere('status.id != :delivered') :
            $builder->andWhere('status.id = :delivered')
        ;

        $builder->setParameter('delivered', OrderStatus::DELIVERED);

        // Admin users (Customer & Company) don't have to see created orders in active orders list.
        if (!$isCustomerUser && $isActive) {
            $builder->andWhere('status.id != :created');

            $builder->setParameter('created', OrderStatus::CREATED);
        }
    }

    /**
     * @param QueryBuilder $builder
     * @param User|null    $user
     */
    private function addUserFilter(QueryBuilder $builder, ?User $user): void
    {
        $builder
            ->andWhere('user.id = :id')
                ->setParameter('id', $user->getId())
        ;
    }

    /**
     * @param QueryBuilder $builder
     * @param int          $page
     */
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
                ->setParameter('search', '%' . $search . '%')
        ;
    }
}
