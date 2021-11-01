<?php

namespace App\Entity;

use App\Repository\GlobalCourseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=GlobalCourseRepository::class)
 */
class GlobalCourse
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=128)
     */
    private $name;

    /**
     * @ORM\Column(type="text")
     */
    private $focus;

    /**
     * @ORM\Column(type="text")
     */
    private $specialization;

    /**
     * @ORM\Column(type="text")
     */
    private $keywords;

    /**
     * @ORM\OneToMany(targetEntity=EmployerCourse::class, mappedBy="course")
     */
    private $employerCourses;

    public function __construct()
    {
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

    public function getFocus(): ?string
    {
        return $this->focus;
    }

    public function setFocus(string $focus): self
    {
        $this->focus = $focus;

        return $this;
    }

    public function getSpecialization(): ?string
    {
        return $this->specialization;
    }

    public function setSpecialization(string $specialization): self
    {
        $this->specialization = $specialization;

        return $this;
    }

    public function getKeywords(): ?string
    {
        return $this->keywords;
    }

    public function setKeywords(string $keywords): self
    {
        $this->keywords = $keywords;

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
            $employerCourse->setCourse($this);
        }

        return $this;
    }

    public function removeEmployerCourse(EmployerCourse $employerCourse): self
    {
        if ($this->employerCourses->removeElement($employerCourse)) {
            // set the owning side to null (unless already changed)
            if ($employerCourse->getCourse() === $this) {
                $employerCourse->setCourse(null);
            }
        }

        return $this;
    }
}
