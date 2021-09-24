<?php

namespace App\DataFixtures;

use App\Entity\SectorSignItem;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class SectorSignItemFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $data = [
            SectorSignItem::GREY => [
                'LUMINAIRE',
                'DÉCORATION INTÉRIEURE',
                'DÉCORATION DU MUR',
                'PEINTURE SPÉCIFIQUE',
                'DROGUERIE',
                'REVÊTEMENT DE SOL',
                'CARRELAGE',
                'CARRELAGE SOL',
                'CARRELAGE MURAL',
                'SALLE DE BAINS',
                'CUISINE',
                'RANGEMENT',
                'MENUISERIE',
                'MENUISERIE INTÉRIEURE',
                'MENUISERIE EXTÉRIEURE',
                'BOIS & DÉCOUPE',
                'BOIS MATÉRIAUX',
                'JARDIN',
                'AMÉNAGEMENT EXTÉRIEUR',
                'ÉLECTRICITÉ',
                'CHAUFFAGE',
                'PLOMBERIE',
                'OUTILLAGE',
                'QUINCAILLERIE',
            ],
            SectorSignItem::BLUE => [
                'CAISSES',
                'SORTIE',
                'CAISSES / SORTIE',
                'ESPACE PROJET',
                'DÉCOUPE',
                'RETRAIT MARCHANDISES',
            ]
        ];

        foreach ($data as $color => $labels) {
            foreach ($labels as $label) {
                $item = new SectorSignItem();
                $item->setLabel($label);
                $item->setColor($color);
                $item->setIsActive(true);

                $manager->persist($item);
            }
        }

        $manager->flush();
    }
}
