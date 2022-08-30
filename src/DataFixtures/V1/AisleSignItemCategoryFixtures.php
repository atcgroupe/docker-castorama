<?php

namespace App\DataFixtures\V1;

use App\Entity\AisleSignItemCategory;
use App\Service\Fixtures\AppVersionFixturesGroup;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;

class AisleSignItemCategoryFixtures extends Fixture implements FixtureGroupInterface
{
    public function load(ObjectManager $manager)
    {
        $data = [
            'BOIS & MENUISERIE',
            'CHAUFFAGE',
            'CUISINE',
            'DECO INTERIEURE',
            'DECO MUR & PEINTURE',
            'ELECTRICITE',
            'JARDIN',
            'LUMINAIRE',
            'OUTILLAGE',
            'PLOMBERIE',
            'QUINCAILLERIE',
            'RANGEMENT',
            'SALLE DE BAIN',
            'SOL',
        ];

        foreach ($data as $entry) {
            $category = new AisleSignItemCategory();

            $category->setLabel($entry);
            $category->setIsActive(true);

            $manager->persist($category);
            $this->setReference($entry, $category);
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
