<?php

namespace App\DataFixtures;

use App\Entity\Event;
use App\Entity\OrderStatus;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class OrderStatusFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $data = [
            ['Envoyée', Event::ORDER_SENT],
            ['Reçue', Event::ORDER_RECEIVED],
            ['En cours de traitement', Event::ORDER_PROCESS],
            ['Traitée', Event::ORDER_PROCESSED],
            ['Expédiée', Event::ORDER_SHIPPED],
            ['Livrée', Event::ORDER_DELIVERED],
        ];

        foreach ($data as $entry) {
            $status = new OrderStatus();
            $status->setLabel($entry[0]);
            $status->setEvent($this->getReference($entry[1]));

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
