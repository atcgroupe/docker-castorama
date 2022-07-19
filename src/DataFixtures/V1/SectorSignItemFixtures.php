<?php

namespace App\DataFixtures\V1;

use App\Entity\SectorSignItem;
use App\Service\Fixtures\AppVersionFixturesGroup;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;

class SectorSignItemFixtures extends Fixture implements FixtureGroupInterface
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
                'PEINTURE',
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

    public static function getGroups(): array
    {
        return [
            AppVersionFixturesGroup::V1,
        ];
    }
}
