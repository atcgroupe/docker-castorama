<?php

namespace App\DataFixtures;

use App\Entity\AisleOrderSign;
use App\Entity\AisleSmallOrderSign;
use App\Entity\SectorOrderSign;
use App\Entity\Sign;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use phpDocumentor\Reflection\Types\Self_;

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
    private const PRICE = 'price';
    private const CUSTOMER_REF = 'customerRef';

    public function load(ObjectManager $manager)
    {
        $data = [
            [
                self::CLASS_NAME => AisleOrderSign::class,
                self::TYPE => AisleOrderSign::getType(),
                self::IMAGE => 'aisle_order_sign.jpg',
                self::TITLE => 'Panneau allée',
                self::DESCRIPTION => 'Format: 800x500mm<br>Impression: Recto/Verso<br>Finition: 2 Perfos hautes<br>Matière: PVC 5MM',
                self::WEIGHT => 0.50,
                self::BUILDER => 'AisleSignBuilder',
                self::TEMPLATE => 'AisleSignTemplate',
                self::PRICE => 14.39,
                self::CUSTOMER_REF => '12AS52115',
            ],
            [
                self::CLASS_NAME => AisleSmallOrderSign::class,
                self::TYPE => AisleSmallOrderSign::getType(),
                self::IMAGE => 'aisle_small_order_sign.jpg',
                self::TITLE => 'Panneau allée New',
                self::DESCRIPTION => 'Format: 800x300mm<br>Impression: Recto/Verso<br>Finition: 2 Perfos hautes<br>Matière: PVC 5MM',
                self::WEIGHT => 0.40,
                self::BUILDER => 'AisleSmallSignBuilder',
                self::TEMPLATE => 'AisleSmallSignTemplate',
                self::PRICE => 9.27,
                self::CUSTOMER_REF => '1RAS52115',
            ],
            [
                self::CLASS_NAME => SectorOrderSign::class,
                self::TYPE => SectorOrderSign::getType(),
                self::IMAGE => 'sector_order_sign.jpg',
                self::TITLE => 'Panneau secteur',
                self::DESCRIPTION => 'Format: 1600x500mm<br>Impression: Recto/Verso<br>Finition: 2 Perfos hautes<br>Matière: PVC 10MM',
                self::WEIGHT => 1.50,
                self::BUILDER => 'SectorSignBuilder',
                self::TEMPLATE => 'SectorSignTemplate',
                self::PRICE => 38.97,
                self::CUSTOMER_REF => '12AS3658',
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
            $sign->setPrice($entry[self::PRICE]);
            $sign->setCustomerReference($entry[self::CUSTOMER_REF]);

            $manager->persist($sign);

            $this->setReference($entry[self::CLASS_NAME], $sign);
        }

        $manager->flush();
    }
}
