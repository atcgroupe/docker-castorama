<?php

namespace App\DataFixtures;

use App\Entity\AisleSignItem;
use App\Service\Fixture\CsvReader;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class AisleSignItemFixtures extends Fixture implements DependentFixtureInterface
{
    private const CATEGORY = 'category';
    private const PRODUCT = 'product';
    private const IMAGE = 'image';

    public function __construct(
        private CsvReader $csvReader,
    ) {
    }

    public function load(ObjectManager $manager)
    {
        // Aisle sign items
        $data = $this->csvReader->getData(
            \dirname(__DIR__, 2) . '/resource/aisle_sign_items.csv',
            [
                self::CATEGORY,
                self::PRODUCT,
                self::IMAGE,
            ]
        );

        foreach ($data as $entry) {
            $item = new AisleSignItem();

            $item->setLabel($entry[self::PRODUCT]);
            $item->setImage($this->getFormattedImageName($entry[self::IMAGE]));
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

    /**
     * @param string $data
     *
     * @return string
     */
    private function getFormattedImageName(string $data): string
    {
        $filter = [
            ' - ' => '_',
            '- ' => '_',
            ' -' => '_',
            ' ' => '_',
            '-' => '_',
            'À' => 'A',
            'Â' => 'A',
            'Ä' => 'A',
            'È' => 'E',
            'É' => 'E',
            'Ê' => 'E',
            'Ë' => 'E',
            'D\'' => '',
            '&' => 'ET',
            'L\'' => '',
            '.' => '',
            'Ç' => 'C',
            'Î' => 'I',
            'Ï' => 'I',
            'Ô' => 'O',
            'Ö' => 'O',
            'Û' => 'U',
            'Ü' => 'U',
        ];

        $searches = [];
        $replaces = [];

        foreach ($filter as $key => $value) {
            $searches[] = $key;
            $replaces[] = $value;
        }

        return strtolower(str_replace($searches, $replaces, strtoupper($data)));
    }
}
