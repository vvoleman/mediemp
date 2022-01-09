<?php

namespace App\Entity;

use App\Repository\CourseRegistrationRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CourseRegistrationRepository::class)
 */
class CourseRegistration {
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=CourseAppointment::class, inversedBy="courseRegistrations")
     * @ORM\JoinColumn(nullable=false)
     */
    private $courseAppointment;

    /**
     * @ORM\ManyToOne(targetEntity=Employee::class, inversedBy="courseRegistrations")
     * @ORM\JoinColumn(nullable=false)
     */
    private $employee;

    /**
     * @ORM\Column(type="smallint",nullable=true)
     */
    private $absence;

    /**
     * @ORM\Column(type="boolean",nullable=true)
     */
    private $test_done;


    public function getId(): ?int {
        return $this->id;
    }

    public function getCourseAppointment(): ?CourseAppointment {
        return $this->courseAppointment;
    }

    public function setCourseAppointment(?CourseAppointment $courseAppointment): self {
        $this->courseAppointment = $courseAppointment;

        return $this;
    }

    public function getEmployee(): ?Employee {
        return $this->employee;
    }

    public function setEmployee(?Employee $employee): self {
        $this->employee = $employee;

        return $this;
    }

    public function getAbsence(): ?int {
        return $this->absence;
    }

    public function setAbsence(int $absence): self {
        $this->absence = $absence;

        return $this;
    }

    public function getTestDone(): ?bool {
        return $this->test_done;
    }

    public function setTestDone(int $test_done): self {
        $this->test_done = $test_done;

        return $this;
    }
}
