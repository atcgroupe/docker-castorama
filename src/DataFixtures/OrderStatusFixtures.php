<?php

namespace App\DataFixtures;

use App\Entity\OrderStatus;
use App\Service\Event\OrderEvent;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class OrderStatusFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $data = [
            [OrderStatus::CREATED, 'Création', null],
            [OrderStatus::SENT, 'Envoyée', OrderEvent::SENT],
            # [OrderStatus::RECEIVED, 'Reçue', OrderEvent::RECEIVED],
            [OrderStatus::PROCESSING, 'En cours de traitement', null],
            # [OrderStatus::PROCESSED, 'Traitée', OrderEvent::PROCESSED],
            [OrderStatus::DELIVERY, 'Expédiée', OrderEvent::SHIPPED],
            [OrderStatus::DELIVERED, 'Livrée', OrderEvent::DELIVERED],
        ];

        foreach ($data as $entry) {
            $status = new OrderStatus();
            $status->setId($entry[0]);
            $status->setLabel($entry[1]);
            if ($entry[2] !== null) {
                $status->setEvent($this->getReference($entry[2]));
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
