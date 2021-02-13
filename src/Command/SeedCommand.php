<?php

namespace App\Command;

use App\Factory\HotelFactory;
use App\Factory\ReviewFactory;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class SeedCommand extends Command
{
    protected static $defaultName = 'app:seed';
    protected static $defaultDescription = 'Fill the database with required data';

    protected int $hotelNumber = 10;
    protected int $reviewNumber = 100000;

    protected function configure()
    {
        $this
            ->setDescription(self::$defaultDescription)
            ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        HotelFactory::new()->many($this->hotelNumber)->create(function (){
            return ['reviews' => ReviewFactory::new()->many(($this->reviewNumber / 10) / $this->hotelNumber)];
        });

        $io->success('Seeding complete');

        return Command::SUCCESS;
    }
}
