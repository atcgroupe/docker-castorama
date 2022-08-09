<?php

namespace App\DataFixtures;

use App\DataFixtures\V2\SignCategoryFixtures;
use App\Entity\Sign;
use App\Repository\SignRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

abstract class AbstractSignFixtures extends Fixture implements FixtureGroupInterface, DependentFixtureInterface
{
    protected const ID = 'id';
    protected const CLASS_NAME = 'class';
    protected const NAME = 'name';
    protected const TITLE = 'title';
    protected const WIDTH = 'width';
    protected const HEIGHT = 'height';
    protected const PRINT_FACES = 'printFaces';
    protected const MATERIAL = 'material';
    protected const FINISH = 'finish';
    protected const WEIGHT = 'weight';
    protected const CUSTOMER_REF = 'customerRef';
    protected const PRICE = 'price';
    protected const BUILDER = 'builder';
    protected const TEMPLATE = 'template';
    protected const VARIABLE = 'variable';
    protected const CATEGORY = 'category';

    /**
     * @var Sign[] $signs
     */
    protected array $signs;

    public function __construct(
        private SignRepository $signRepository
    ) {
    }

    public function load(ObjectManager $manager)
    {
        $data = $this->getSignsData();

        foreach ($data as $entry) {
            $existingSign = $this->signRepository->find($entry[self::ID]);
            $sign = ($existingSign instanceof Sign) ? $existingSign : new Sign();

            $sign->setId($entry[self::ID]);
            $sign->setClass($entry[self::CLASS_NAME]);
            $sign->setName($entry[self::NAME]);
            $sign->setTitle($entry[self::TITLE]);
            $sign->setWidth($entry[self::WIDTH]);
            $sign->setHeight($entry[self::HEIGHT]);
            $sign->setPrintFaces($entry[self::PRINT_FACES]);
            $sign->setMaterial($entry[self::MATERIAL]);
            $sign->setFinish($entry[self::FINISH]);
            $sign->setWeight($entry[self::WEIGHT]);
            $sign->setCustomerReference($entry[self::CUSTOMER_REF]);
            $sign->setPrice($entry[self::PRICE]);
            $sign->setSwitchFlowBuilder($entry[self::BUILDER]);
            $sign->setSwitchFlowTemplateFile($entry[self::TEMPLATE]);
            $sign->setIsVariable($entry[self::VARIABLE]);
            $sign->setIsActive(true);
            $sign->setCategory($this->getReference($entry[self::CATEGORY]));

            if (!$existingSign instanceof Sign) {
                $manager->persist($sign);
            }
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            SignCategoryFixtures::class,
        ];
    }

    /**
     * @return Sign[]
     */
    abstract protected function getSignsData(): array;
}
