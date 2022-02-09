<?php

namespace App\DataFixtures;

use App\Entity\CourseAppointment;
use App\Entity\CourseRegistration;
use App\Entity\EmployerCourse;
use App\Entity\GlobalCourse;
use App\Factory\CourseAppointmentFactory;
use App\Repository\EmployerRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Proxies\__CG__\App\Entity\Employer;
use function Zenstruck\Foundry\faker;

class CoursesFixtures extends Fixture implements DependentFixtureInterface, FixtureGroupInterface
{

    private EmployerRepository $employerRepository;

    public function __construct(EmployerRepository $employerRepository) {
        $this->employerRepository = $employerRepository;
    }

    public function load(ObjectManager $manager): void
    {
        $courses = [];
        for ($i = 0; $i < 20; $i++) {
            $course = new GlobalCourse();
            $course->setName("Test course " . $i);
            $course->setFocus("Test focus " . $i);
            $course->setKeywords("keyword1, keyword" . $i);
            $course->setSpecialization("Test specialization " . $i);
            $courses[] = $course;
            $manager->persist($course);
        }
        try {
            $generator = Factory::create("cs_CZ");
            $employers = $this->employerRepository->findAll();
            echo "employers: ".sizeof($employers)."\n";
            /** @var Employer $e */
            foreach ($employers as $e){
                foreach ($courses as $c){
                    if(rand(1,10) < 4) continue;
                    $empCourse = new EmployerCourse();
                    $empCourse->setEmployer($e);
                    $empCourse->setCourse($c);
                    $manager->persist($empCourse);
                    $employees = $e->getEmployees()->toArray();
                    for ($i=0;$i<2;$i++){
                        $isPast = rand(1,10) < 7;
                        $appointment = new CourseAppointment();
                        $appointment->setCapacity($generator->numberBetween(1,100));
                        if($isPast){
                            $appointment->setDate($generator->dateTimeBetween("-1 year","now"));
                        }else{
                            $appointment->setDate($generator->dateTimeBetween("now","+2 months"));
                        }
                        $appointment->setPlace($generator->city);
                        $appointment->setEmployerCourse($empCourse);
                        $chosen = $this->getPercentItems($employees,50);
                        $manager->persist($appointment);
                        foreach($chosen as $ch){
                            $registration = new CourseRegistration();
                            $registration->setCourseAppointment($appointment);
                            $registration->setEmployee($ch);
                            if($isPast){
                                $absence = (rand(1,10) < 7);
                                $registration->setAbsence($absence);
                                if($absence){
                                    $registration->setTestDone(rand(1,10),8);
                                }
                            }
                            $registration->setNotificationStatus("pending");
                            $manager->persist($registration);
                        }
                    }
                }
            }
        }catch (\Exception $exception){
            die(print_r($exception));
        }


        echo "here\n";
        try{
            $manager->flush();
        }catch (\Exception $e){
            die(print_r($e));
        }
    }

    public function getDependencies() {
        return [
            ZAppFixtures::class
        ];
    }

    public static function getGroups(): array {
        return ['group1', 'group2','aaa'];
    }

    public function getPercentItems(array $items, int $percentage): array {
        $out = [];
        foreach ($items as $item) {
            if(rand(0,100) <= $percentage) $out[] = $item;
        }
        return $out;
    }

}
