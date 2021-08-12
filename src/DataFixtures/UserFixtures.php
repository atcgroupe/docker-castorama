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
    private const USERNAME = 'username';
    private const PASSWORD = 'password';

    public function __construct(
        private UserPasswordHasherInterface $passwordHasher,
        private CsvReader $csvReader,
    ) {
    }

    public function load(ObjectManager $manager)
    {
        // Shops users
        $shopUsersData = $this->csvReader->getData(
            \dirname(__DIR__, 2) . '/resource/shop_listing.csv',
            [
                ShopFixtures::SHOP_NAME,
                self::USERNAME,
                self::PASSWORD,
            ]
        );

        foreach ($shopUsersData as $entry) {
            $user = new User();

            $user->setUsername($entry[self::USERNAME]);
            $user->setPassword($this->passwordHasher->hashPassword($user, $entry[self::PASSWORD]));
            $user->setRoles([User::ROLE_CUSTOMER_SHOP]);
            $user->setIsActive(true);
            $user->setShop($this->getReference($entry[ShopFixtures::SHOP_NAME]));

            $manager->persist($user);
        }

        // Other users
        $otherUsersData = [
            ['Siege', 'pass', User::ROLE_CUSTOMER_ADMIN],
            ['atcgroupe', 'pass', User::ROLE_COMPANY_ADMIN],
            ['api', 'pass', User::ROLE_API],
        ];

        foreach ($otherUsersData as $entry) {
            $user = new User();

            $user->setUsername($entry[0]);
            $user->setPassword($this->passwordHasher->hashPassword($user, $entry[1]));
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
