<?php

namespace App\Command;

use App\Entity\User;
use App\Service\Fixture\CsvReader;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[AsCommand(
    name: 'app:set-users-list',
    description: 'Renames sign item image',
)]
class UserListCommand extends Command
{
    private const shopName = 'shopName';
    private const username = 'username';
    private const city = 'city';
    private const postalCode = 'postalCode';
    private const address = 'address';
    private const region = 'region';
    private const password = 'password';

    public function __construct(
        private UserPasswordHasherInterface $passwordHasher,
        private CsvReader $csvReader,
        string $name = null,
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $filesystem = new Filesystem();
        $fileName = \dirname(__DIR__, 2) . '/resource/shop_listing_pw_encoded.csv';

        // Remove old file
        $io->writeln('Remove old shop list');
        $filesystem->remove($fileName);
        $io->writeln('Old shop list has been removed');

        // Create new file
        $io->writeln('Creating new file');
        $filesystem->appendToFile(
            $fileName,
            sprintf(
                "%s;%s;%s;%s;%s;%s;%s\n",
                self::shopName,
                self::username,
                self::city,
                self::postalCode,
                self::address,
                self::region,
                self::password,
            )
        );
        $io->writeln('New file created');

        // Set shops data
        $shopUsersData = $this->csvReader->getData(
            \dirname(__DIR__, 2) . '/resource/shop_listing.csv',
            [
                self::shopName,
                self::username,
                self::city,
                self::postalCode,
                self::address,
                self::region,
                self::password,
            ]
        );

        $io->writeln('Writing shop data');

        $count = count($shopUsersData);
        $i = 0;

        foreach ($shopUsersData as $entry) {
            $i++;

            $filesystem->appendToFile(
                $fileName,
                sprintf(
                    "%s;%s;%s;%s;%s;%s;%s%s",
                    $entry[self::shopName],
                    $entry[self::username],
                    $entry[self::city],
                    $entry[self::postalCode],
                    $entry[self::address],
                    $entry[self::region],
                    $this->passwordHasher->hashPassword(
                        (new User())->setUsername($entry[self::username]),
                        $entry[self::password]
                    ),
                    ($i < $count) ? "\n" : "",
                )
            );
        }

        $io->success('The images has been renamed successfully!');

        return Command::SUCCESS;
    }
}
