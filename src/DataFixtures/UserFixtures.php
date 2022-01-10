<?php

namespace App\DataFixtures;

use App\Entity\EmployerLine;
use App\Entity\User;
use App\Factory\EmployeeFactory;
use App\Factory\EmployerFactory;
use App\Factory\UserFactory;
use App\Repository\EmployerLineRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\PasswordHasher\PasswordHasherInterface;

class UserFixtures extends Fixture implements DependentFixtureInterface,FixtureGroupInterface{

    private EmployerLineRepository $lineRepository;

    private UserPasswordHasherInterface $hasher;
    private EntityManagerInterface $entityManager;

    public function __construct(EmployerLineRepository      $lineRepository,
                                UserPasswordHasherInterface $hasher,
                                EntityManagerInterface      $entityManager
    ) {
        $this->lineRepository = $lineRepository;
        $this->hasher = $hasher;
        $this->entityManager = $entityManager;
    }

    public function load(ObjectManager $manager): void {
        $conn = $this->entityManager->getConnection();
        $conn->executeStatement("ALTER TABLE user AUTO_INCREMENT = 1;ALTER TABLE admin AUTO_INCREMENT = 1;ALTER TABLE employee AUTO_INCREMENT = 1;ALTER TABLE employer AUTO_INCREMENT = 1");

        $lines = $this->lineRepository->getFirst(0, 1);
        $employerFactory = EmployerFactory::new();
        $userFactory = UserFactory::new();
        $employeeFactory = EmployeeFactory::new();
        $password = $this->hasher->hashPassword(new User(), "heslo123");
        foreach ($lines as $line) {
            /** @var EmployerLine $line */
            $employer = $employerFactory->create([
                'name' => $line->getFacilityName(),
                'address' => $line->getAddress(),
                'provider_type' => $line->getFacilityType(),
                'form_of_care' => $line->getFormOfCare(),
                'confirmed_at' => new \DateTimeImmutable(),
                "line_id" => $line
            ]);
            for ($i = 0; $i < 10; $i++) {
                $user = $userFactory->create([
                    "password" => $password,
                    "type" => "employee"
                ]);

                $employee = $employeeFactory->create([
                    "identity" => $user,
                    "employer" => $employer
                ]);
            }
        }

        $manager->flush();
    }

    public function getDependencies() {
        return [
            EmployerLineFixtures::class
        ];
    }

    public static function getGroups(): array {
        return ['group1', 'group2'];
    }
}
