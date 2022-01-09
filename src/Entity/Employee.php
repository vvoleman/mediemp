<?php

namespace App\Entity;

use App\Repository\EmployeeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=EmployeeRepository::class)
 */
class Employee {

    public const TYPE_NAME = "employee";

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Employer::class, inversedBy="employees")
     * @ORM\JoinColumn(nullable=false)
     */
    private $employer;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $surname;

    /**
     * @ORM\Column(type="string", length=32)
     */
    private $degree;

    /**
     * @ORM\Column(type="date")
     */
    private $birthday;

    /**
     * @ORM\Column(type="string", length=128)
     */
    private $birth_city;

    /**
     * @ORM\Column(type="string", length=32)
     */
    private $citizenship;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $designation_of_professional_competence;

    /**
     * @ORM\Column(type="string", length=64)
     */
    private $diploma_number;

    /**
     * @ORM\Column(type="date")
     */
    private $diploma_date;

    /**
     * @ORM\Column(type="text")
     */
    private $specialized_competency;

    /**
     * @ORM\Column(type="text")
     */
    private $special_professional_or_special_specialized_competencies;

    /**
     * @ORM\Column(type="text")
     */
    private $identification_data_of_the_educational_establishment;

    /**
     * @ORM\OneToMany(targetEntity=CourseRegistration::class, mappedBy="employee")
     */
    private $courseRegistrations;

    /**
     * @ORM\ManyToOne(targetEntity=Employer::class, inversedBy="managers")
     */
    private $managing;

    /**
     * @ORM\OneToOne(targetEntity=User::class, inversedBy="employee", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private ?User $identity;

    public function __construct() {
        $this->courseRegistrations = new ArrayCollection();
    }

    public function getId(): ?int {
        return $this->id;
    }

    public function getEmployer(): ?Employer {
        return $this->employer;
    }

    public function setEmployer(?Employer $employer): self {
        $this->employer = $employer;

        return $this;
    }

    public function getName(): ?string {
        return $this->name;
    }

    public function setName(string $name): self {
        $this->name = $name;

        return $this;
    }

    public function getSurname(): ?string {
        return $this->surname;
    }

    public function setSurname(string $surname): self {
        $this->surname = $surname;

        return $this;
    }

    public function getDegree(): ?string {
        return $this->degree;
    }

    public function setDegree(string $degree): self {
        $this->degree = $degree;

        return $this;
    }

    public function getBirthday(): ?\DateTimeInterface {
        return $this->birthday;
    }

    public function setBirthday(\DateTimeInterface $birthday): self {
        $this->birthday = $birthday;

        return $this;
    }

    public function getBirthCity(): ?string {
        return $this->birth_city;
    }

    public function setBirthCity(string $birth_city): self {
        $this->birth_city = $birth_city;

        return $this;
    }

    public function getCitizenship(): ?string {
        return $this->citizenship;
    }

    public function setCitizenship(string $citizenship): self {
        $this->citizenship = $citizenship;

        return $this;
    }

    public function getDesignationOfProfessionalCompetence(): ?string {
        return $this->designation_of_professional_competence;
    }

    public function setDesignationOfProfessionalCompetence(string $designation_of_professional_competence): self {
        $this->designation_of_professional_competence = $designation_of_professional_competence;

        return $this;
    }

    public function getDiplomaNumber(): ?string {
        return $this->diploma_number;
    }

    public function setDiplomaNumber(string $diploma_number): self {
        $this->diploma_number = $diploma_number;

        return $this;
    }

    public function getDiplomaDate(): ?\DateTime {
        return $this->diploma_date;
    }

    public function setDiplomaDate(\DateTime $diploma_date): self {
        $this->diploma_date = $diploma_date;

        return $this;
    }

    public function getSpecializedCompetency(): ?string {
        return $this->specialized_competency;
    }

    public function setSpecializedCompetency(string $specialized_competency): self {
        $this->specialized_competency = $specialized_competency;

        return $this;
    }

    public function getSpecialProfessionalOrSpecialSpecializedCompetencies(): ?string {
        return $this->special_professional_or_special_specialized_competencies;
    }

    public function setSpecialProfessionalOrSpecialSpecializedCompetencies(string $special_professional_or_special_specialized_competencies): self {
        $this->special_professional_or_special_specialized_competencies = $special_professional_or_special_specialized_competencies;

        return $this;
    }

    public function getIdentificationDataOfTheEducationalEstablishment(): ?string {
        return $this->identification_data_of_the_educational_establishment;
    }

    public function setIdentificationDataOfTheEducationalEstablishment(string $identification_data_of_the_educational_establishment): self {
        $this->identification_data_of_the_educational_establishment = $identification_data_of_the_educational_establishment;

        return $this;
    }

    /**
     * @return Collection|CourseRegistration[]
     */
    public function getCourseRegistrations(): Collection {
        return $this->courseRegistrations;
    }

    public function addCourseRegistration(CourseRegistration $courseRegistration): self {
        if (!$this->courseRegistrations->contains($courseRegistration)) {
            $this->courseRegistrations[] = $courseRegistration;
            $courseRegistration->setEmployee($this);
        }

        return $this;
    }

    public function removeCourseRegistration(CourseRegistration $courseRegistration): self {
        if ($this->courseRegistrations->removeElement($courseRegistration)) {
            // set the owning side to null (unless already changed)
            if ($courseRegistration->getEmployee() === $this) {
                $courseRegistration->setEmployee(null);
            }
        }

        return $this;
    }

    public function getFullname($reverse = false): string {
        $data = [$this->name, $this->surname];
        if ($reverse) $data = array_reverse($data);

        return sprintf("%s %s", ...$data);
    }

    public function getManaging(): ?Employer {
        return $this->managing;
    }

    public function setManaging(?Employer $managing): self {
        $this->managing = $managing;

        return $this;
    }

    public function isManager(): bool {
        return !!$this->getManaging();
    }

    public function getIdentity(): ?User
    {
        return $this->identity;
    }

    public function setIdentity(User $identity): self
    {
        $this->identity = $identity;

        return $this;
    }
}
