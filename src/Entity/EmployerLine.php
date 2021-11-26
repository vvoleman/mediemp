<?php

namespace App\Entity;

use App\Repository\EmployerLineRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EmployerLineRepository::class)
 */
class EmployerLine {
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $medicalFacilityId;

    /**
     * @ORM\Column(type="integer")
     */
    private $code;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $facilityName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $facilityType;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $address;

    /**
     * @ORM\Column(type="integer", length=9)
     */
    private $phoneNumber;

    /**
     * @ORM\Column(type="string", length=128)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=128)
     */
    private $web;

    /**
     * @ORM\Column(type="integer", length=8)
     */
    private $ico;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $fieldOfCare;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $formOfCare;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $typeOfCare;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $representative;

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

    public function getMunicipality(): ?string {
        return $this->municipality;
    }

    public function setMunicipality(string $municipality): self {
        $this->municipality = $municipality;

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

    public function getPsc(): ?int {
        return $this->psc;
    }

    public function setPsc(int $psc): self {
        $this->psc = $psc;

        return $this;
    }

    public function getStreet(): ?string {
        return $this->street;
    }

    public function setStreet(string $street): self {
        $this->street = $street;
        return $this;
    }
}
