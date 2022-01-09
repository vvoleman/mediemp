<?php

namespace App\Entity;

use App\Repository\EmployerCourseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EmployerCourseRepository::class)
 */
class EmployerCourse
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Employer::class, inversedBy="employerCourses")
     */
    private $employer;

    /**
     * @ORM\ManyToOne(targetEntity=GlobalCourse::class, inversedBy="employerCourses")
     * @ORM\JoinColumn(nullable=false)
     */
    private $course;

    /**
     * @ORM\OneToMany(targetEntity=CourseAppointment::class, mappedBy="employerCourse")
     */
    private $courseAppointments;

    public function __construct()
    {
        $this->courseAppointments = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmployer(): ?Employer
    {
        return $this->employer;
    }

    public function setEmployer(?Employer $employer): self
    {
        $this->employer = $employer;

        return $this;
    }

    public function getCourse(): ?GlobalCourse
    {
        return $this->course;
    }

    public function setCourse(?GlobalCourse $course): self
    {
        $this->course = $course;

        return $this;
    }

    /**
     * @return Collection|CourseAppointment[]
     */
    public function getCourseAppointments(): Collection
    {
        return $this->courseAppointments;
    }

    public function addCourseAppointment(CourseAppointment $courseAppointment): self
    {
        if (!$this->courseAppointments->contains($courseAppointment)) {
            $this->courseAppointments[] = $courseAppointment;
            $courseAppointment->setEmployerCourse($this);
        }

        return $this;
    }

    public function removeCourseAppointment(CourseAppointment $courseAppointment): self
    {
        if ($this->courseAppointments->removeElement($courseAppointment)) {
            // set the owning side to null (unless already changed)
            if ($courseAppointment->getEmployerCourse() === $this) {
                $courseAppointment->setEmployerCourse(null);
            }
        }

        return $this;
    }

    public function getFilteredAppointments(bool $finished = true): Collection|array {
        return array_filter($this->getCourseAppointments()->toArray(),function ($x)use($finished){
            /** @var CourseAppointment $x */
            return ($finished) ? $x->isOver() : !$x->isOver();
        });
    }
}
