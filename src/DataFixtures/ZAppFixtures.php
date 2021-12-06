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
use App\Service\Entity\EmployerLineService;
use App\Service\Entity\EmployerService;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class ZAppFixtures extends Fixture {

    use PersistArrayTrait;

    private UserPasswordHasherInterface $passwordHasher;
    private EntityManagerInterface $entityManager;
    private EmployerLineRepository $lineRepository;
    private EmployerService $employerService;

    public function __construct(UserPasswordHasherInterface $passwordHasher,
                                EntityManagerInterface      $entityManager,
                                EmployerLineRepository      $lineRepository,
                                EmployerService             $employerService) {

        $this->passwordHasher = $passwordHasher;
        $this->entityManager = $entityManager;
        $this->lineRepository = $lineRepository;
        $this->employerService = $employerService;
    }

    public function load(ObjectManager $manager): void {
        //Potřebuju přidat 5 organizací, každá bude mít 10 zaměstnanců
        //Potřebuju přidat 1 uživatele-zaměstnance, uživatele-admina


        $conn = $this->entityManager->getConnection();
        $conn->executeStatement("ALTER TABLE user AUTO_INCREMENT = 1;ALTER TABLE admin AUTO_INCREMENT = 1;ALTER TABLE employee AUTO_INCREMENT = 1;ALTER TABLE employer AUTO_INCREMENT = 1");

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
            $employer = $this->employerService->postEmployer(EmployerLineService::formatArrayToEmployer($this->lineRepository->find(189734), "employer@test.cz"));
            $manager->persist($employer);
            $employee = EmployeeFactory::new()->create(["identity" => $u->object(), "employer" => $employer, "name" => "Jan", "surname" => "Novák"]);

        } catch (\Exception $e) {
            die(print_r($e));
        }

        $employers = $this->lineRepository->getFirst();


        try {
            foreach ($employers as $employer) {
                /** @var Employer $employer */
                $employer = $this->employerService->postEmployer(EmployerLineService::formatArrayToEmployer($employer));
                $manager->persist($employer);
                for($i=0;$i<5;$i++){
                    EmployeeFactory::new()->create([
                        'employer'=>$employer
                    ]);
                }
            }
        }catch (\Exception $e){
            die(print_r($e));
        }
        $manager->flush();
    }
}
