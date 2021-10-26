<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Service\Fixture\CsvReader;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture implements DependentFixtureInterface
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
            \dirname(__DIR__, 2) . '/resource/shop_listing_pw_encoded.csv',
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
            [User::SIEGE, '$2y$13$2Ua2zF536TC.sXGzI4tl.e1XVdC9njoi1i1IEXs4sHyLn6u7bkS5G', User::ROLE_CUSTOMER_ADMIN],
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
}
