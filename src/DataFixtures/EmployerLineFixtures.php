<?php

namespace App\DataFixtures;

use App\Service\Entity\EmployerLineService;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\ORM\NoResultException;
use Doctrine\Persistence\ObjectManager;

class EmployerLineFixtures extends Fixture implements DependentFixtureInterface,FixtureGroupInterface
{

    private EmployerLineService $lineService;

    public function __construct(EmployerLineService $lineService) {
        $this->lineService = $lineService;
    }

    public function load(ObjectManager $manager): void {
        $this->lineService->update();
    }

    public function getDependencies() {
        return [DataAssetFixtures::class];
    }

    public static function getGroups(): array {
        return ['group2'];
    }
}
