<?php

namespace App\DataFixtures;

use App\Entity\Employee;
use App\Factory\EmployeeFactory;
use App\Factory\EmployerFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture {

    use PersistArrayTrait;

    private UserPasswordHasherInterface $passwordHasher;
    private EntityManagerInterface $entityManager;

    public function __construct(UserPasswordHasherInterface $passwordHasher,EntityManagerInterface $entityManager) {

        $this->passwordHasher = $passwordHasher;
        $this->entityManager = $entityManager;
    }

    public function load(ObjectManager $manager): void {
        $conn = $this->entityManager->getConnection();
        $conn->executeStatement("ALTER TABLE employee AUTO_INCREMENT = 1;ALTER TABLE employer AUTO_INCREMENT = 1");

        $hashed = $this->passwordHasher->hashPassword(new Employee(), "heslo123");

        //static
        $e = EmployerFactory::new()->create([
            "name"=>"Krajská nemocnice Liberec"
        ]);
        $manager->persist($e->object());
        $u = EmployeeFactory::new()->create([
            "employer"=>$e->object(),
            "email"=>"test@test.cz",
            "name"=>"Jan",
            "surname"=>"Novák",
            "password"=>$hashed,
            "managing"=>$e->object()
        ]);
        $manager->persist($u->object());

        //dynamic
        $employees = EmployerFactory::new()->createMany(5);
        $employees[] = $e;
        foreach ($employees as $e) {
            $manager->persist($e->object());
            $users = EmployeeFactory::new()->createMany(10, [
                "password" => $hashed,
                "employer" => $e->object()
            ]);
            $this->persistArrayProxies($manager,$users);
        }

        $manager->flush();
    }
}
