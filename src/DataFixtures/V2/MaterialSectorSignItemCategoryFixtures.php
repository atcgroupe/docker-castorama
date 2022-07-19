<?php

namespace App\DataFixtures\V2;

use App\Entity\MaterialSectorSignItemCategory;
use App\Service\Fixtures\AppVersionFixturesGroup;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;

class MaterialSectorSignItemCategoryFixtures extends Fixture implements FixtureGroupInterface
{
    public function load(ObjectManager $manager)
    {
        $categories = [
            'CATEGORIE UNE',
            'CATEGORIE DEUX',
            'CATEGORIE TROIS',
        ];

        foreach ($categories as $label) {
            $category = new MaterialSectorSignItemCategory();
            $category->setLabel($label);
            $category->setIsActive(true);

            $manager->persist($category);
            $this->setReference($label, $category);
        }

        $manager->flush();
    }

    public static function getGroups(): array
    {
        return [
            AppVersionFixturesGroup::V2,
        ];
    }
}
