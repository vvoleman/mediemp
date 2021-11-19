<?php

namespace App\DataFixtures;

use App\Factory\GlobalCourseFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CoursesFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        throw new \Exception("Test");
        die;
        $courses = GlobalCourseFactory::new()->createMany(20);
        dd($courses);
        foreach ($courses as $c) {

            $manager->persist($c->object());
        }
        $manager->flush();
    }
}
