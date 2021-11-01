<?php

namespace App\DataFixtures;

use App\Entity\Employee;
use App\Factory\EmployeeFactory;
use App\Factory\EmployerFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture {

    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher) {

        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void {
        $hashed = $this->passwordHasher->hashPassword(new Employee(), "heslo123");

        //static
        $e = EmployerFactory::new()->create([
            "name"=>"Krajská nemocnice Liberec"
        ]);
        $manager->persist($e->object());
        $u = EmployeeFactory::new()->create([
            "employer"=>$e->object(),
            "email"=>"test@test.cz",
            "password"=>$hashed
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
            foreach ($users as $u) {
                $manager->persist($u->object());
            }
        }

        $manager->flush();
    }
}
