<?php

namespace App\Entity;

use App\Repository\EmployerLineRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=EmployerLineRepository::class)
 */
class EmployerLine {
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"safe"})
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"safe"})
     */
    private $medicalFacilityId;

    /**
     * @ORM\Column(type="bigint")
     * @Groups({"safe"})
     */
    private $code;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"safe"})
     */
    private $facilityName;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"safe"})
     */
    private $facilityType;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"safe"})
     */
    private $address;

    /**
     * @ORM\Column(type="string", length=32, nullable="true")
     * @Groups({"safe"})
     */
    private $phoneNumber;

    /**
     * @ORM\Column(type="string", length=128,nullable="true")
     *
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=128,nullable="true")
     * @Groups({"safe"})
     */
    private $web;

    /**
     * @ORM\Column(type="integer", length=8,nullable="true")
     * @Groups({"safe"})
     */
    private $ico;

    /**
     * @ORM\Column(type="text")
     * @Groups({"safe"})
     */
    private $fieldOfCare;

    /**
     * @ORM\Column(type="text")
     * @Groups({"safe"})
     */
    private $formOfCare;

    /**
     * @ORM\Column(type="text")
     * @Groups({"safe"})
     */
    private $typeOfCare;

    /**
     * @ORM\Column(type="text")
     * @Groups({"safe"})
     */
    private $representative;

    /**
     * @ORM\OneToOne(targetEntity=Employer::class, mappedBy="lineId", cascade={"persist", "remove"})
     */
    private $employer;

    public function getId(): ?int {
        return $this->id;
    }

    public function getMedicalFacilityId(): ?int {
        return $this->medicalFacilityId;
    }

    public function setMedicalFacilityId(int $medicalFacilityId): self {
        $this->medicalFacilityId = $medicalFacilityId;

        return $this;
    }

    public function getCode(): ?int {
        return $this->code;
    }

    public function setCode(int $code): self {
        $this->code = $code;

        return $this;
    }

    public function getFacilityName(): ?string {
        return $this->facilityName;
    }

    public function setFacilityName(string $facilityName): self {
        $this->facilityName = $facilityName;

        return $this;
    }

    public function getFacilityType(): ?string {
        return $this->facilityType;
    }

    public function setFacilityType(string $facilityType): self {
        $this->facilityType = $facilityType;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getAddress() {
        return $this->address;
    }

    /**
     * @param mixed $address
     */
    public function setAddress($address): void {
        $this->address = $address;
    }

    /**
     * @return mixed
     */
    public function getPhoneNumber() {
        return $this->phoneNumber;
    }

    /**
     * @param mixed $phoneNumber
     */
    public function setPhoneNumber($phoneNumber): void {
        $this->phoneNumber = $phoneNumber;
    }

    /**
     * @return mixed
     */
    public function getEmail() {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email): void {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getWeb() {
        return $this->web;
    }

    /**
     * @param mixed $web
     */
    public function setWeb($web): void {
        $this->web = $web;
    }

    /**
     * @return mixed
     */
    public function getIco() {
        return $this->ico;
    }

    /**
     * @param mixed $ico
     */
    public function setIco($ico): void {
        $this->ico = $ico;
    }

    /**
     * @return mixed
     */
    public function getFieldOfCare() {
        return $this->fieldOfCare;
    }

    /**
     * @param mixed $fieldOfCare
     */
    public function setFieldOfCare($fieldOfCare): void {
        $this->fieldOfCare = $fieldOfCare;
    }

    /**
     * @return mixed
     */
    public function getFormOfCare() {
        return $this->formOfCare;
    }

    /**
     * @param mixed $formOfCare
     */
    public function setFormOfCare($formOfCare): void {
        $this->formOfCare = $formOfCare;
    }

    /**
     * @return mixed
     */
    public function getTypeOfCare() {
        return $this->typeOfCare;
    }

    /**
     * @param mixed $typeOfCare
     */
    public function setTypeOfCare($typeOfCare): void {
        $this->typeOfCare = $typeOfCare;
    }

    /**
     * @return mixed
     */
    public function getRepresentative() {
        return $this->representative;
    }

    /**
     * @param mixed $representative
     */
    public function setRepresentative($representative): void {
        $this->representative = $representative;
    }

    public function getEmployer(): ?Employer
    {
        return $this->employer;
    }

    public function setEmployer(?Employer $employer): self
    {
        // unset the owning side of the relation if necessary
        if ($employer === null && $this->employer !== null) {
            $this->employer->setLineId(null);
        }

        // set the owning side of the relation if necessary
        if ($employer !== null && $employer->getLineId() !== $this) {
            $employer->setLineId($this);
        }

        $this->employer = $employer;

        return $this;
    }
}
