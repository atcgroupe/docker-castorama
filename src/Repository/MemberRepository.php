<?php

namespace App\Repository;

use App\Entity\Event;
use App\Entity\Member;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Member|null find($id, $lockMode = null, $lockVersion = null)
 * @method Member|null findOneBy(array $criteria, array $orderBy = null)
 * @method Member[]    findAll()
 * @method Member[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MemberRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Member::class);
    }

    /**
     * @param Event $event
     * @param User  $user
     *
     * @return Member[]
     */
    public function findByEventAndUser(Event $event, User $user)
    {
        $qb = $this->createQueryBuilder('m');

        return $qb
            ->innerJoin('m.events', 'events')
            ->innerJoin('m.user', 'user')
            ->andWhere('events.id = :id')
                ->setParameter('id', $event->getId())
            ->andWhere($qb->expr()->in('user.username', '?1'))
                ->setParameter('1', [$user->getUserIdentifier(), User::ATC, User::SIEGE])
            ->getQuery()
            ->getResult();
    }
}
