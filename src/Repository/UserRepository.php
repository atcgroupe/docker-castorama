<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository implements PasswordUpgraderInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function upgradePassword(PasswordAuthenticatedUserInterface $user, string $newHashedPassword): void
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', \get_class($user)));
        }

        $user->setPassword($newHashedPassword);
        $this->_em->persist($user);
        $this->_em->flush();
    }

    /**
     * @return User[]
     */
    public function findShopsUsers(): array
    {
        return $this->createQueryBuilder('u')
            ->innerJoin('u.shop', 's')
            ->addSelect('s')
            ->orderBy('u.username')
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * @return User[]
     */
    public function findActiveShopsUsers(): array
    {
        return $this->createQueryBuilder('u')
            ->innerJoin('u.shop', 's')
            ->addSelect('s')
            ->andWhere('u.isActive = 1')
            ->orderBy('u.username')
            ->getQuery()
            ->getResult()
            ;
    }

    /**
     * @param int $id
     *
     * @return User
     * @throws NoResultException
     * @throws NonUniqueResultException
     */
    public function findWithShop(int $id): User
    {
        return $this->createQueryBuilder('u')
            ->innerJoin('u.shop', 's')
            ->addSelect('s')
            ->andWhere('u.id = :id')
                ->setParameter('id', $id)
            ->getQuery()
            ->getSingleResult()
            ;
    }
}
