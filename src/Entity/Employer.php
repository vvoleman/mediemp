<?php

namespace App\Entity;

use App\Repository\EmployerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

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
     * @Assert\NotBlank
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     */
    private $address;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     */
    private $provider_type;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
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

    /**
     * @ORM\OneToMany(targetEntity=Employee::class, mappedBy="managing")
     */
    private $managers;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime_immutable", nullable=true)
     */
    private $confirmedAt;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $confirmToken;

    public function __construct()
    {
        $this->employees = new ArrayCollection();
        $this->employerCourses = new ArrayCollection();
        $this->managers = new ArrayCollection();
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
    public function getEmployees(): Collection{
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

    /**
     * @return Collection|Employee[]
     */
    public function getManagers(): Collection
    {
        return $this->managers;
    }

    public function addManager(Employee $manager): self
    {
        if (!$this->managers->contains($manager)) {
            $this->managers[] = $manager;
            $manager->setManaging($this);
        }

        return $this;
    }

    public function removeManager(Employee $manager): self
    {
        if ($this->managers->removeElement($manager)) {
            // set the owning side to null (unless already changed)
            if ($manager->getManaging() === $this) {
                $manager->setManaging(null);
            }
        }

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getConfirmedAt(): ?\DateTimeImmutable
    {
        return $this->confirmedAt;
    }

    public function setConfirmedAt(?\DateTimeImmutable $confirmedAt): self
    {
        $this->confirmedAt = $confirmedAt;

        return $this;
    }

    public function getConfirmToken(): ?string
    {
        return $this->confirmToken;
    }

    public function setConfirmToken(string $confirmToken): self
    {
        $this->confirmToken = $confirmToken;

        return $this;
    }
}
