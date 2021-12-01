<?php

namespace App\DataFixtures;

use App\Entity\Admin;
use App\Entity\Employee;
use App\Entity\User;
use App\Factory\EmployeeFactory;
use App\Factory\EmployerFactory;
use App\Factory\UserFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class ZAppFixtures extends Fixture {

    use PersistArrayTrait;

    private UserPasswordHasherInterface $passwordHasher;
    private EntityManagerInterface $entityManager;

    public function __construct(UserPasswordHasherInterface $passwordHasher,EntityManagerInterface $entityManager) {

        $this->passwordHasher = $passwordHasher;
        $this->entityManager = $entityManager;
    }

    public function load(ObjectManager $manager): void {
        //Potřebuju přidat 5 organizací, každá bude mít 10 zaměstnanců
        //Potřebuju přidat 1 uživatele-zaměstnance, uživatele-admina


        $conn = $this->entityManager->getConnection();
        $conn->executeStatement("ALTER TABLE user AUTO_INCREMENT = 1;ALTER TABLE admin AUTO_INCREMENT = 1;ALTER TABLE employee AUTO_INCREMENT = 1;ALTER TABLE employer AUTO_INCREMENT = 1");

        $hashed = $this->passwordHasher->hashPassword(new User(), "heslo123");

        //user-admin
        $u = UserFactory::new()->create(["type"=>"admin","email"=>"admin@test.cz","password"=>$hashed]);
        $a = new Admin();
        $a->setIdentity($u->object());
        $manager->persist($a);

        //user-employee

        try {
            $u = UserFactory::new()->create(["email"=>"test@test.cz","password"=>$hashed,"type"=>"employee"]);
            $employer = EmployerFactory::new()->create(["name"=>"Krajská nemocnice v Liberci"]);
            $employee = EmployeeFactory::new()->create(["identity"=>$u->object(),"employer"=>$employer->object(),"name"=>"Jan","surname"=>"Novák"]);

        }catch (\Exception $e){
            die(print_r($e));
        }

        $employers = EmployerFactory::new()->createMany(5);
        foreach ($employers as $employer){
            $employees = EmployeeFactory::new()->createMany(5);
            foreach ($employees as $employee) {
                $employee->setEmployer($employer);
            }
        }

        $manager->flush();
    }
}
