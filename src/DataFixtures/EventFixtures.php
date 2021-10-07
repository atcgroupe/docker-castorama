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
                "Lorsque vous validez une commande",
                "Merci pour votre commande!. Elle a été envoyée avec succès."
            ],
            /*
            [
                2,
                OrderEvent::RECEIVED,
                "Commande reçue",
                "Lorsqu'un membre de notre équipe a réceptionné votre commande.",
                "Merci pour votre commande!. Elle a bien été reçue par nos équipes et sera traitée dans les meilleurs délais."
            ],
            [
                3,
                OrderEvent::PROCESS,
                "Commande en cours de traitement",
                "Votre commande est en cours de traitement par nos équipes.",
                "Votre commande avance!. Elle est en cours de traitement par nos équipes."
            ],
            [
                4,
                OrderEvent::PROCESSED,
                "Commande traitée",
                "Votre commande est fabriquée et est prêtre à vous être expédiée",
                "Votre commande est prête!. Elle sera expédiée très prochainement."
            ],
            */
            [
                5,
                OrderEvent::SHIPPED,
                "Commande expédiée",
                "Votre commande a été expédiée.",
                "Votre commande a été expédiée!."
            ],
            [
                6,
                OrderEvent::DELIVERED,
                "Commande livrée",
                "Votre commande a été livrée en magasin.",
                "Votre commande a été livrée en magasin!. Merci et a bientôt"
            ]
        ];

        foreach ($data as $entry) {
            $event = new Event();
            $event->setDisplayOrder($entry[0]);
            $event->setId($entry[1]);
            $event->setLabel($entry[2]);
            $event->setHelp($entry[3]);
            $event->setEmailMessage($entry[4]);

            $manager->persist($event);

            $this->addReference($entry[1], $event);
        }

        $manager->flush();
    }
}
