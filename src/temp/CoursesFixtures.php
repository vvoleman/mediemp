<?php

namespace App\DataFixtures;

use App\Entity\GlobalCourse;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CoursesFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 20; $i++) {
            $course = new GlobalCourse();
            $course->setName("Test course " . $i);
            $course->setFocus("Test focus " . $i);
            $course->setKeywords("keyword1, keyword" . $i);
            $course->setSpecialization("Test specialization " . $i);
            $manager->persist($course);
        }



        $manager->flush();
    }
}
