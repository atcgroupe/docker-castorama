<?php

namespace App\DataFixtures;

use App\Entity\AisleOrderSign;
use App\Entity\SignItemCategory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class SignItemCategoryFixtures extends Fixture implements DependentFixtureInterface
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
            'SALE DE BAIN',
            'SOL',
            'BÂTI EXTÉRIEUR',
            'BÂTI EXTÉRIEUR 2',
        ];

        foreach ($data as $entry) {
            $category = new SignItemCategory();

            $category->setLabel($entry);
            $category->setIsActive(true);
            $category->setSign($this->getReference(AisleOrderSign::class));

            $manager->persist($category);
            $this->setReference($entry, $category);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            SignFixtures::class,
        ];
    }
}
