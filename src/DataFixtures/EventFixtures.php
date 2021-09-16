<?php

namespace App\DataFixtures;

use App\Entity\Event;
use App\Service\Event\OrderEvent;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class EventFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $data = [
            [
                1,
                OrderEvent::SENT,
                "Commande validée",
                "Lorsque vous validez une commande"
            ],
            [
                2,
                OrderEvent::RECEIVED,
                "Commande reçue",
                "Lorsqu'un membre de notre équipe a réceptionné votre commande."
            ],
            [
                3,
                OrderEvent::PROCESS,
                "Commande en cours de traitement",
                "Votre commande est en cours de traitement par nos équipes."
            ],
            [
                4,
                OrderEvent::PROCESSED,
                "Commande traitée",
                "Votre commande est fabriquée et est prêtre à vous être expédiée"
            ],
            [
                5,
                OrderEvent::SHIPPED,
                "Commande expédiée",
                "Votre commande a été expédiée."
            ],
            [
                6,
                OrderEvent::RECEIVED,
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
