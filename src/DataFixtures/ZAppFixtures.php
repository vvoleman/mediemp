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
        $conn = $this->entityManager->getConnection();
        $conn->executeStatement("ALTER TABLE user AUTO_INCREMENT = 1;ALTER TABLE admin AUTO_INCREMENT = 1;ALTER TABLE employee AUTO_INCREMENT = 1;ALTER TABLE employer AUTO_INCREMENT = 1");

        $hashed = $this->passwordHasher->hashPassword(new User(), "heslo123");

        //static
        //admin
        $u = UserFactory::new()->create(["type"=>"admin","email"=>"admin@test.cz","password"=>$hashed]);
        $a = new Admin();
        $a->setIdentity($u->object());
        $manager->persist($u->object());
        $manager->persist($a);
        //employer
        $e = EmployerFactory::new()->create([
            "name"=>"Krajská nemocnice Liberec"
        ]);
        $manager->persist($e->object());
        //employee
        $u = UserFactory::new()->create(["type"=>"employee","email"=>"test@test.cz","password"=>$hashed]);
        $e = EmployeeFactory::new()->create([
            "employer"=>$e->object(),
            "name"=>"Jan",
            "identity"=>$u,
            "surname"=>"Novák",
            "managing"=>$e->object()
        ]);
        $manager->persist($u->object());
        $manager->persist($e->object());

        //dynamic
        $employers = EmployerFactory::new()->createMany(5);
        $employees[] = $e;
        foreach ($employers as $e) {
            $manager->persist($e->object());
            $users=[];
            for($i=0;$i<10;$i++){
                $u = UserFactory::new()->create(["type"=>"employee","password"=>$hashed]);
                $employees[] = EmployeeFactory::new()->create(["employer"=>$e->object(),"identity"=>$u]);
                $users[] = $u;
            }
            $this->persistArrayProxies($manager,$users);
        }
        $this->persistArrayProxies($manager,$employers);
        $this->persistArrayProxies($manager,$employees);

        $manager->flush();
    }
}
