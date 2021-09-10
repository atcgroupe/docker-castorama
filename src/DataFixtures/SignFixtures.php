<?php

namespace App\DataFixtures;

use App\Entity\AisleOrderSign;
use App\Entity\SectorOrderSign;
use App\Entity\Sign;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class SignFixtures extends Fixture
{
    private const CLASS_NAME = 'class';
    private const IMAGE = 'image';
    private const TITLE = 'title';
    private const DESCRIPTION = 'description';
    private const WEIGHT = 'weight';
    private const BUILDER = 'builder';
    private const TEMPLATE = 'template';
    private const TYPE = 'type';

    public function load(ObjectManager $manager)
    {
        $data = [
            [
                self::CLASS_NAME => AisleOrderSign::class,
                self::TYPE => 'aisle',
                self::IMAGE => 'aisle_order_sign.jpg',
                self::TITLE => 'Panneau allée',
                self::DESCRIPTION => 'Format: 800x500mm<br>Impression: Recto/Verso<br>Matière: PVC 5MM',
                self::WEIGHT => 0.50,
                self::BUILDER => 'AisleSignBuilder',
                self::TEMPLATE => 'AisleSignTemplate',
            ],
            [
                self::CLASS_NAME => SectorOrderSign::class,
                self::TYPE => 'sector',
                self::IMAGE => 'sector_order_sign.jpg',
                self::TITLE => 'Panneau secteur',
                self::DESCRIPTION => 'Format: 1600x500mm<br>Impression: Recto/Verso<br>Matière: PVC 10MM',
                self::WEIGHT => 1.50,
                self::BUILDER => 'SectorSignBuilder',
                self::TEMPLATE => 'SectorSignTemplate',
            ]
        ];

        foreach ($data as $entry) {
            $sign = new Sign();

            $sign->setClass($entry[self::CLASS_NAME]);
            $sign->setType($entry[self::TYPE]);
            $sign->setImage($entry[self::IMAGE]);
            $sign->setTitle($entry[self::TITLE]);
            $sign->setDescription($entry[self::DESCRIPTION]);
            $sign->setWeight($entry[self::WEIGHT]);
            $sign->setSwitchFlowBuilder($entry[self::BUILDER]);
            $sign->setSwitchFlowTemplateFile($entry[self::TEMPLATE]);
            $sign->setIsActive(true);

            $manager->persist($sign);

            $this->setReference($entry[self::CLASS_NAME], $sign);
        }

        $manager->flush();
    }
}
