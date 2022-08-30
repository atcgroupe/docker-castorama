<?php

namespace App\DataFixtures\V1;

use App\Entity\User;
use App\Service\Fixture\CsvReader;
use App\Service\Fixtures\AppVersionFixturesGroup;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture implements DependentFixtureInterface, FixtureGroupInterface
{
    public const USERNAME = 'username';
    public const PASSWORD = 'password';

    public function __construct(
        private CsvReader $csvReader,
    ) {
    }

    public function load(ObjectManager $manager)
    {
        // Shops users
        $shopUsersData = $this->csvReader->getData(
            \dirname(__DIR__, 3) . '/resource/shop_listing_pw_encoded.csv',
            [
                ShopFixtures::SHOP_NAME,
                self::USERNAME,
                self::PASSWORD,
            ]
        );

        foreach ($shopUsersData as $entry) {
            $user = new User();

            $user->setUsername($entry[self::USERNAME]);
            $user->setPassword($entry[self::PASSWORD]);
            $user->setRoles([User::ROLE_CUSTOMER_SHOP]);
            $user->setIsActive(true);
            $user->setShop($this->getReference($entry[ShopFixtures::SHOP_NAME]));

            $manager->persist($user);
        }

        // Other users
        $otherUsersData = [
            [User::SIEGE, '$2y$13$.5t9jaL8UhipGpiiCL37uuc3LM41dww/fvoX1Bbqov.RkMkgsk0bW', User::ROLE_CUSTOMER_ADMIN],
            [User::ATC, '$2y$13$M10IrrBjgRspS8ktrDvj6e06coR0sAm0gQXWUnIdwwLsSp5mARiFa', User::ROLE_COMPANY_ADMIN],
            [User::API, '$2y$13$Aak6GQHVlv.q7bQxIU066.FbxWprK7/EpWUKdYI6Td72wfMOTEL5e', User::ROLE_API],
        ];

        foreach ($otherUsersData as $entry) {
            $user = new User();

            $user->setUsername($entry[0]);
            $user->setPassword($entry[1]);
            $user->setRoles([$entry[2]]);
            $user->setIsActive(true);

            $manager->persist($user);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            ShopFixtures::class,
        ];
    }

    public static function getGroups(): array
    {
        return [
            AppVersionFixturesGroup::V1,
        ];
    }
}
