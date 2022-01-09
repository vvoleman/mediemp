<?php

namespace App\Command;

use App\Repository\EmployerLineRepository;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'employers:size',
    description: 'Returns amount of employers',
)]
class EmployersSizeCommand extends Command {

    private EmployerLineRepository $repository;

    public function __construct(EmployerLineRepository $repository, string $name = null){
        parent::__construct($name);
        $this->repository = $repository;
    }

    protected function configure(): void {

    }

    protected function execute(InputInterface $input, OutputInterface $output): int {
        $io = new SymfonyStyle($input, $output);

        $io->info(sprintf("Size of employers: %d",$this->repository->getSize()));

        return Command::SUCCESS;
    }
}
