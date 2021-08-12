<?php

namespace App\DataFixtures;

use App\Entity\SignItemCategory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class SignItemCategoryFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $data = [
            'Sélectionnez une catégorie',
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
            'SALE DE BAIN',
            'SOL',
            'BÂTI EXTÉRIEUR',
            'BÂTI EXTÉRIEUR 2',
        ];

        foreach ($data as $entry) {
            $category = new SignItemCategory();

            $category->setLabel($entry);
            $category->setIsActive(true);

            $manager->persist($category);
            $this->setReference($entry, $category);
        }

        $manager->flush();
    }
}
