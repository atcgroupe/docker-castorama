<?php

namespace App\DataFixtures\V1;

use App\Entity\AisleSignItem;
use App\Service\Fixture\CsvReader;
use App\Service\Fixtures\AppVersionFixturesGroup;
use App\Service\Image\ImageNameFormatter;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class AisleSignItemFixtures extends Fixture implements DependentFixtureInterface, FixtureGroupInterface
{
    private const CATEGORY = 'category';
    private const PRODUCT = 'product';
    private const IMAGE = 'image';

    public function __construct(
        private CsvReader $csvReader,
        private ImageNameFormatter $formatter,
    ) {
    }

    public function load(ObjectManager $manager)
    {
        // Aisle sign items
        $data = $this->csvReader->getData(
            \dirname(__DIR__, 3) . '/resource/aisle_sign_items.csv',
            [
                self::CATEGORY,
                self::PRODUCT,
                self::IMAGE,
            ]
        );

        foreach ($data as $entry) {
            $item = new AisleSignItem();

            $item->setLabel($entry[self::PRODUCT]);
            $item->setImage($this->formatter->getFormattedName($entry[self::IMAGE]));
            $item->setIsActive(true);
            $item->setCategory($this->getReference($entry[self::CATEGORY]));

            $manager->persist($item);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            AisleSignItemCategoryFixtures::class,
        ];
    }

    public static function getGroups(): array
    {
        return [
            AppVersionFixturesGroup::V1,
        ];
    }
}
