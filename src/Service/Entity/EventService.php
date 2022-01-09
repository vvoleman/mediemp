<?php

namespace App\Service\Entity;

use App\Entity\CourseRegistration;
use App\Entity\Employee;
use App\Repository\CourseRegistrationRepository;
use JetBrains\PhpStorm\ArrayShape;

class EventService {

    private CourseRegistrationRepository $repository;

    public function __construct(CourseRegistrationRepository $repository) {
        $this->repository = $repository;
    }

    public function get(Employee $employee,\DateTime $from = null, \DateTime $to = null): array {
        $results = $this->repository->getBetweenDates($employee,$from,$to);

        $events = [];

        /** @var CourseRegistration $r */
        foreach ($results as $r){
            $date = $r->getCourseAppointment()->getDate()->format("Y-m-d");
            $events[$date][] = $this->prepareArray($r);
        }

        return $events;
    }

    #[ArrayShape(["id" => "int|null", "date" => "\DateTimeInterface|null", "place" => "null|string", "name" => "null|string", "keywords" => "null|string"])]
    private function prepareArray(CourseRegistration $c): array{
        return [
            "id"=>$c->getId(),
            "date"=>$c->getCourseAppointment()->getDate(),
            "place"=>$c->getCourseAppointment()->getPlace(),
            "name"=>$c->getCourseAppointment()->getEmployerCourse()->getCourse()->getName(),
            "keywords"=>$c->getCourseAppointment()->getEmployerCourse()->getCourse()->getKeywords()
        ];
    }

}