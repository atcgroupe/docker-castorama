<?php

namespace App\DataFixtures;

use App\Entity\Event;
use App\Entity\Order;
use App\Entity\OrderStatus;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class OrderStatusFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $data = [
            [OrderStatus::CREATED, null],
            [OrderStatus::SENT, Event::ORDER_SENT],
            [OrderStatus::RECEIVED, Event::ORDER_RECEIVED],
            [OrderStatus::PROCESSING, Event::ORDER_PROCESS],
            [OrderStatus::PROCESSED, Event::ORDER_PROCESSED],
            [OrderStatus::DELIVERY, Event::ORDER_SHIPPED],
            [OrderStatus::DELIVERED, Event::ORDER_DELIVERED],
        ];

        foreach ($data as $entry) {
            $status = new OrderStatus();
            $status->setLabel($entry[0]);
            if ($entry[1] !== null) {
                $status->setEvent($this->getReference($entry[1]));
            }

            $manager->persist($status);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        Return [
            EventFixtures::class,
        ];
    }
}
