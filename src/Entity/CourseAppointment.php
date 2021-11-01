<?php

namespace App\Entity;

use App\Repository\CourseAppointmentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CourseAppointmentRepository::class)
 */
class CourseAppointment
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=EmployerCourse::class, inversedBy="courseAppointments")
     * @ORM\JoinColumn(nullable=false)
     */
    private $employerCourse;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $place;

    /**
     * @ORM\Column(type="integer")
     */
    private $capacity;

    /**
     * @ORM\OneToMany(targetEntity=CourseRegistration::class, mappedBy="courseAppointment")
     */
    private $courseRegistrations;

    public function __construct()
    {
        $this->courseRegistrations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmployerCourse(): ?EmployerCourse
    {
        return $this->employerCourse;
    }

    public function setEmployerCourse(?EmployerCourse $employerCourse): self
    {
        $this->employerCourse = $employerCourse;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getPlace(): ?string
    {
        return $this->place;
    }

    public function setPlace(string $place): self
    {
        $this->place = $place;

        return $this;
    }

    public function getCapacity(): ?int
    {
        return $this->capacity;
    }

    public function setCapacity(int $capacity): self
    {
        $this->capacity = $capacity;

        return $this;
    }

    /**
     * @return Collection|CourseRegistration[]
     */
    public function getCourseRegistrations(): Collection
    {
        return $this->courseRegistrations;
    }

    public function addCourseRegistration(CourseRegistration $courseRegistration): self
    {
        if (!$this->courseRegistrations->contains($courseRegistration)) {
            $this->courseRegistrations[] = $courseRegistration;
            $courseRegistration->setCourseAppointment($this);
        }

        return $this;
    }

    public function removeCourseRegistration(CourseRegistration $courseRegistration): self
    {
        if ($this->courseRegistrations->removeElement($courseRegistration)) {
            // set the owning side to null (unless already changed)
            if ($courseRegistration->getCourseAppointment() === $this) {
                $courseRegistration->setCourseAppointment(null);
            }
        }

        return $this;
    }
}
