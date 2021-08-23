<?php

namespace App\DataFixtures;

use App\Entity\Event;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class EventFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $data = [
            [
                1,
                Event::ORDER_SENT,
                "Commande validée",
                "Lorsque vous validez une commande"
            ],
            [
                2,
                Event::ORDER_RECEIVED,
                "Commande reçue",
                "Lorsqu'un membre de notre équipe a réceptionné votre commande."
            ],
            [
                3,
                Event::ORDER_PROCESS,
                "Commande en cours de traitement",
                "Votre commande est en cours de traitement par nos équipes."
            ],
            [
                4,
                Event::ORDER_PROCESSED,
                "Commande traitée",
                "Votre commande est fabriquée et est prêtre à vous être expédiée"
            ],
            [
                5,
                Event::ORDER_SHIPPED,
                "Commande expédiée",
                "Votre commande a été expédiée."
            ],
            [
                6,
                Event::ORDER_DELIVERED,
                "Commande livrée",
                "Votre commande a été livrée en magasin."
            ]
        ];

        foreach ($data as $entry) {
            $event = new Event();
            $event->setDisplayOrder($entry[0]);
            $event->setId($entry[1]);
            $event->setLabel($entry[2]);
            $event->setHelp($entry[3]);

            $manager->persist($event);

            $this->addReference($entry[1], $event);
        }

        $manager->flush();
    }
}
