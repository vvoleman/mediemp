<?php

namespace App\Entity;

use App\Repository\CourseRegistrationRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CourseRegistrationRepository::class)
 */
class CourseRegistration
{
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
     * @ORM\Column(type="smallint")
     */
    private $absence;

    /**
     * @ORM\Column(type="smallint")
     */
    private $test_done;

    /**
     * @ORM\Column(type="string", length=32)
     */
    private $notification_status;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCourseAppointment(): ?CourseAppointment
    {
        return $this->courseAppointment;
    }

    public function setCourseAppointment(?CourseAppointment $courseAppointment): self
    {
        $this->courseAppointment = $courseAppointment;

        return $this;
    }

    public function getEmployee(): ?Employee
    {
        return $this->employee;
    }

    public function setEmployee(?Employee $employee): self
    {
        $this->employee = $employee;

        return $this;
    }

    public function getAbsence(): ?int
    {
        return $this->absence;
    }

    public function setAbsence(int $absence): self
    {
        $this->absence = $absence;

        return $this;
    }

    public function getTestDone(): ?int
    {
        return $this->test_done;
    }

    public function setTestDone(int $test_done): self
    {
        $this->test_done = $test_done;

        return $this;
    }

    public function getNotificationStatus(): ?string
    {
        return $this->notification_status;
    }

    public function setNotificationStatus(string $notification_status): self
    {
        $this->notification_status = $notification_status;

        return $this;
    }
}
