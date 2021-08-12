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
                Event::ORDER_SENT,
                "Commande validée",
                "Lorsque vous validez une commande"
            ],
            [
                Event::ORDER_RECEIVED,
                "Commande reçue",
                "Lorsqu'un membre de notre équipe a réceptionné votre commande."
            ],
            [
                Event::ORDER_PROCESS,
                "Commande en cours de traitement",
                "Votre commande est en cours de traitement par nos équipes."
            ],
            [
                Event::ORDER_PROCESSED,
                "Commande traitée",
                "Votre commande est fabriquée et est prêtre à vous être expédiée"
            ],
            [
                Event::ORDER_SHIPPED,
                "Commande expédiée",
                "Votre commande a été expédiée."
            ],
            [
                Event::ORDER_DELIVERED,
                "Commande livrée",
                "Votre commande a été livrée en magasin."
            ]
        ];

        foreach ($data as $entry) {
            $event = new Event();
            $event->setId($entry[0]);
            $event->setLabel($entry[1]);
            $event->setHelp($entry[2]);

            $manager->persist($event);

            $this->addReference($entry[0], $event);
        }

        $manager->flush();
    }
}
