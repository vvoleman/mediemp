<?php

namespace App\DataFixtures;

use App\Service\Entity\EmployerLineService;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\ORM\NoResultException;
use Doctrine\Persistence\ObjectManager;

class EmployerLineFixtures extends Fixture
{

    private EmployerLineService $lineService;

    public function __construct(EmployerLineService $lineService) {
        $this->lineService = $lineService;
    }

    public function load(ObjectManager $manager): void {
        $this->lineService->update();
    }
}
