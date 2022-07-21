<?php

namespace App\DataFixtures\V2;

use App\Entity\MaterialAlgecoSignItem;
use App\Service\Fixtures\AppVersionFixturesGroup;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;

class MaterialAlgecoSignItemFixtures extends Fixture implements FixtureGroupInterface
{
    public function load(ObjectManager $manager): void
    {
        $productFamilies = [
            'cloison',
            'isolation',
            'charpente',
            'couverture',
        ];

        foreach ($productFamilies as $label) {
            $family = new MaterialAlgecoSignItem();
            $family->setLabel($label);
            $family->setIsActive(true);

            $manager->persist($family);
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
