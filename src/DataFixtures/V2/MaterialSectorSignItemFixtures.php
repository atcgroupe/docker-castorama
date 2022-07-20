<?php

namespace App\DataFixtures\V2;

use App\Entity\MaterialSectorSignItem;
use App\Service\Fixture\CsvReader;
use App\Service\Fixtures\AppVersionFixturesGroup;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class MaterialSectorSignItemFixtures extends Fixture implements DependentFixtureInterface, FixtureGroupInterface
{
    private const CATEGORY = 'category';
    private const PRODUCT = 'product';

    public function __construct(
        private CsvReader $csvReader,
    ) {}

    public function load(ObjectManager $manager)
    {
        // Aisle sign items
        $data = $this->csvReader->getData(
            \dirname(__DIR__, 3) . '/resource/material_sector_sign_items.csv',
            [
                self::CATEGORY,
                self::PRODUCT,
            ]
        );

        foreach ($data as $entry) {
            $item = new MaterialSectorSignItem();

            $item->setLabel($entry[self::PRODUCT]);
            $item->setIsActive(true);
            $item->setCategory($this->getReference($entry[self::CATEGORY]));

            $manager->persist($item);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            MaterialSectorSignItemCategoryFixtures::class,
        ];
    }

    public static function getGroups(): array
    {
        return [
            AppVersionFixturesGroup::V2,
        ];
    }
}
