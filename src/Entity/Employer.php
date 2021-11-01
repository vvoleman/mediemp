<?php

namespace App\Entity;

use App\Repository\EmployerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EmployerRepository::class)
 */
class Employer
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $address;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $provider_type;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $form_of_care;

    /**
     * @ORM\OneToMany(targetEntity=Employee::class, mappedBy="employer")
     */
    private $employees;

    /**
     * @ORM\OneToMany(targetEntity=EmployerCourse::class, mappedBy="employer")
     */
    private $employerCourses;

    public function __construct()
    {
        $this->employees = new ArrayCollection();
        $this->employerCourses = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getProviderType(): ?string
    {
        return $this->provider_type;
    }

    public function setProviderType(string $provider_type): self
    {
        $this->provider_type = $provider_type;

        return $this;
    }

    public function getFormOfCare(): ?string
    {
        return $this->form_of_care;
    }

    public function setFormOfCare(string $form_of_care): self
    {
        $this->form_of_care = $form_of_care;

        return $this;
    }

    /**
     * @return Collection|Employee[]
     */
    public function getEmployees(): Collection
    {
        return $this->employees;
    }

    public function addEmployee(Employee $employee): self
    {
        if (!$this->employees->contains($employee)) {
            $this->employees[] = $employee;
            $employee->setEmployer($this);
        }

        return $this;
    }

    public function removeEmployee(Employee $employee): self
    {
        if ($this->employees->removeElement($employee)) {
            // set the owning side to null (unless already changed)
            if ($employee->getEmployer() === $this) {
                $employee->setEmployer(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|EmployerCourse[]
     */
    public function getEmployerCourses(): Collection
    {
        return $this->employerCourses;
    }

    public function addEmployerCourse(EmployerCourse $employerCourse): self
    {
        if (!$this->employerCourses->contains($employerCourse)) {
            $this->employerCourses[] = $employerCourse;
            $employerCourse->setEmployer($this);
        }

        return $this;
    }

    public function removeEmployerCourse(EmployerCourse $employerCourse): self
    {
        if ($this->employerCourses->removeElement($employerCourse)) {
            // set the owning side to null (unless already changed)
            if ($employerCourse->getEmployer() === $this) {
                $employerCourse->setEmployer(null);
            }
        }

        return $this;
    }
}
