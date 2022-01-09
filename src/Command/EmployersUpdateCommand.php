<?php

namespace App\Command;

use App\Repository\EmployerLineRepository;
use App\Service\Entity\EmployerLineService;
use App\Service\Util\TimeTrackerTrait;
use Doctrine\ORM\NoResultException;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'employers:update',
    description: 'Reloads employers from API',
)]
class EmployersUpdateCommand extends Command
{
    use TimeTrackerTrait;

    private EmployerLineService $service;
    private EmployerLineRepository $repository;

    public function __construct(EmployerLineService $service,EmployerLineRepository $repository, string $name = null){
        parent::__construct($name);
        $this->service = $service;
        $this->repository = $repository;
    }

    protected function configure(): void
    {
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        if($this->repository->isEmpty()){
            $io->info("Table empty, inserting employers...");
        }else{
            $io->info("Updating employers...");
        }


        try {
            $this->start();
            $this->service->update();
            $io->success(sprintf('Employers were successfully updated [%fs]!',$this->stop()));
            return Command::SUCCESS;
        } catch (NoResultException $e) {
            $io->error("Unable to update employers: " . $e->getMessage());
            $this->stop();
            return Command::FAILURE;
        }
    }
}
