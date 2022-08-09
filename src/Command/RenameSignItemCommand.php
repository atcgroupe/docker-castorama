<?php

namespace App\Command;

use App\Service\Image\ImageNameFormatter;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Filesystem\Filesystem;

#[AsCommand(
    name: 'app:rename-sign-item',
    description: 'Renames sign item image',
)]
class RenameSignItemCommand extends Command
{
    public function __construct(
        private ImageNameFormatter $formatter,
        string $name = null,
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $inputPath = __DIR__ . '/../../resource/picto/in/';
        $outputPath = __DIR__ . '/../../resource/picto/out/';
        $list = $this->getImagesList($inputPath);

        $filesystem = new Filesystem();

        foreach ($list as $item) {
            $filesystem->rename($inputPath . $item, $outputPath . $this->formatter->getFormattedFilename($item));
        }

        $io->success('The images has been renamed successfully!');

        return Command::SUCCESS;
    }

    private function getImagesList(string $dir): array
    {
        $scan = scandir($dir);
        $list = [];

        foreach ($scan as $item) {
            if ($item !== '.' && $item !== '..' && !is_dir($item)) {
                $list[] = $item;
            }
        }

        return $list;
    }
}
