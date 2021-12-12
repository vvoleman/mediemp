<?php

namespace App\Service\Entity;

use App\Entity\Employee;
use App\Entity\Employer;
use App\Security\LoggerAwareTrait;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class EmployeeService {

    use LoggerAwareTrait;

    private EntityManagerInterface $entityManager;
    private ValidatorInterface $validator;

    public function __construct(EntityManagerInterface $entityManager,ValidatorInterface $validator) {
        $this->entityManager = $entityManager;
        $this->validator = $validator;
    }

    public function postEmployee(array $data, Employer $employer) {
        $employee = $this->assembleEmployee($data,$employer);

        $errors = $this->validator->validate($employer);
        if ($errors->count() > 0) {
            $this->getLogger()->warning("Employer validation failed", [
                "errors" => $errors,
                "employer" => $employer
            ]);
            return false;
        }

        $this->entityManager->persist($employee);
        $this->entityManager->flush();
    }

    public function assembleEmployee(array $data, Employer $employer) {
        $employee = new Employee();
        $employee->setName($this->get($data,"name"));
        $employee->setSurname($this->get($data,"surname"));
        $employee->setDegree($this->get($data,"degree"));
        $employee->setBirthday(new \DateTimeImmutable($this->get($data,"name")));
        $employee->setBirthCity($this->get($data,"birthcity"));
        $employee->setCitizenship($this->get($data,"citizenship"));
        $employee->setDesignationOfProfessionalCompetence(($this->get($data,"designation_of_professional_competence")));
        $employee->setSpecializedCompetency($this->get($data,"specialized_competency"));
        $employee->setDiplomaNumber($this->get($data,"diploma_number"));
        $employee->setDiplomaDate(new \DateTime($this->get($data,"diploma_date")));
        $employee->setIdentificationDataOfTheEducationalEstablishment($this->get($data,"idee"));
        $employee->setEmployer($employer);
        return $employee;
    }

    private function get(array $arr, string $key, string $default = null){
        if(array_key_exists($key,$arr)) return $arr[$key];

        return $default;
    }

}