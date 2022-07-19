<?php

namespace App\DataFixtures;

use App\Entity\Sign;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;

abstract class AbstractSignFixtures extends Fixture implements FixtureGroupInterface
{
    protected const ID = 'id';
    protected const CLASS_NAME = 'class';
    protected const IMAGE = 'image';
    protected const TITLE = 'title';
    protected const DESCRIPTION = 'description';
    protected const WEIGHT = 'weight';
    protected const BUILDER = 'builder';
    protected const TEMPLATE = 'template';
    protected const TYPE = 'type';
    protected const PRICE = 'price';
    protected const CUSTOMER_REF = 'customerRef';
    protected const CATEGORY = 'category';

    /**
     * @var Sign[] $signs
     */
    protected array $signs;

    public function load(ObjectManager $manager)
    {
        $data = $this->getSignsData();

        foreach ($data as $entry) {
            $sign = new Sign();

            $sign->setId($entry[self::ID]);
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
            $sign->setCategory($entry[self::CATEGORY]);

            $manager->persist($sign);

            $this->setReference($entry[self::CLASS_NAME], $sign);
        }

        $manager->flush();
    }

    /**
     * @return Sign[]
     */
    abstract protected function getSignsData(): array;
}
