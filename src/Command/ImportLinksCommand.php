<?php

namespace App\Command;

use App\Entity\Link;
use App\Entity\Tag;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:import-links',
    description: 'Add a short description for your command',
)]
class ImportLinksCommand extends Command
{
    public function __construct(private readonly EntityManagerInterface $entityManager)
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $csvFile = 'var/links.csv';

        if (!file_exists($csvFile) || !is_readable($csvFile)) {
            $io->error('CSV file does not exist or is not readable.');
            return Command::FAILURE;
        }

        $io->title('Starting import of links from var/links.csv');

        $fileHandle = fopen($csvFile, 'r');
        if ($fileHandle === false) {
            $io->error('Failed to open the CSV file.');
            return Command::FAILURE;
        }

        // Reading the header
        $headers = fgetcsv($fileHandle, 0, ',');

        if ($headers === false) {
            $io->error('Failed to read the CSV headers.');
            return Command::FAILURE;
        }

        $importedCount = 0;

        while (($data = fgetcsv($fileHandle, 0, ',')) !== false) {
            $record = array_combine($headers, $data);

            if ($record === false) {
                continue;
            }

            $link = new Link();
            $link->setUrl($record['url']);
            $link->setTitle($record['title']);
            $link->setMetaDescription($record['description'] ?? null);
            $link->setIsPrivate($record['is_private'] === 'true');
            $link->setStatus($record['status']);
            $link->setCreatedAt(new \DateTimeImmutable($record['created_at']));
            $link->setUpdatedAt($record['updated_at'] ? new \DateTimeImmutable($record['updated_at']) : null);

            $tagNames = explode(',', $record['tags']);
            foreach ($tagNames as $tagName) {
                $tagName = trim($tagName);
                if (!empty($tagName)) {
                    $tag = $this->entityManager->getRepository(Tag::class)->findOneBy(['name' => $tagName]);
                    if (!$tag) {
                        $tag = new Tag();
                        $tag->setName($tagName);
                        $this->entityManager->persist($tag);
                    }
                    $link->addTag($tag);
                }
            }

            $this->entityManager->persist($link);
            $importedCount++;
        }

        fclose($fileHandle);

        $this->entityManager->flush();

        $io->success(sprintf('Successfully imported %d links.', $importedCount));

        return Command::SUCCESS;
    }
}
