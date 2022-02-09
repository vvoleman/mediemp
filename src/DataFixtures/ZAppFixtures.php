<?php

namespace App\DataFixtures;

use App\Entity\Admin;
use App\Entity\Employee;
use App\Entity\Employer;
use App\Entity\EmployerLine;
use App\Entity\User;
use App\Factory\EmployeeFactory;
use App\Factory\EmployerFactory;
use App\Factory\UserFactory;
use App\Repository\EmployerLineRepository;
use App\Repository\EmployerRepository;
use App\Service\Entity\EmployerLineService;
use App\Service\Entity\EmployerService;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class ZAppFixtures extends Fixture implements DependentFixtureInterface,FixtureGroupInterface{

    use PersistArrayTrait;

    private UserPasswordHasherInterface $passwordHasher;
    private EntityManagerInterface $entityManager;
    private EmployerLineRepository $lineRepository;
    private EmployerService $employerService;
    private EmployerRepository $employerRepository;

    public function __construct(UserPasswordHasherInterface $passwordHasher,
                                EntityManagerInterface      $entityManager,
                                EmployerLineRepository      $lineRepository,
                                EmployerService             $employerService,
                                EmployerRepository          $employerRepository) {

        $this->passwordHasher = $passwordHasher;
        $this->entityManager = $entityManager;
        $this->lineRepository = $lineRepository;
        $this->employerService = $employerService;
        $this->employerRepository = $employerRepository;
    }

    public function load(ObjectManager $manager): void {
        //return;
        //Potřebuju přidat 5 organizací, každá bude mít 10 zaměstnanců
        //Potřebuju přidat 1 uživatele-zaměstnance, uživatele-admina

        $hashed = $this->passwordHasher->hashPassword(new User(), "heslo123");

        //user-admin
        $u = UserFactory::new()->create(["type" => "admin", "email" => "admin@test.cz", "password" => $hashed]);
        $a = new Admin();
        $a->setIdentity($u->object());
        $manager->persist($a);

        //user-employee

        try {
            $u = UserFactory::new()->create(["email" => "test@test.cz", "password" => $hashed, "type" => "employee"]);
//            $employer = EmployerFactory::new()->create(["name" => "Krajská nemocnice v Liberci"]);
            $employer = $this->employerRepository->getFirst()[0];
            $employee = EmployeeFactory::new()->create(["identity" => $u->object(), "employer" => $employer, "name" => "Jan", "surname" => "Novák", "managing" => $employer]);

        } catch (\Exception $e) {
            die(print_r($e));
        }

        $manager->flush();
    }

    public function getDependencies() {
        return [
          UserFixtures::class,
        ];
    }

    public static function getGroups(): array {
        return ['group1', 'group2','aaa'];
    }
}
