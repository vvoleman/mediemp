<?php

namespace App\Service\Entity;

use App\Entity\Employee;
use App\Entity\Employer;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class EmployerService {

    private EntityManagerInterface $entityManager;
    private ValidatorInterface $validator;

    public function __construct(EntityManagerInterface $entityManager, ValidatorInterface $validator) {
        $this->entityManager = $entityManager;
        $this->validator = $validator;
    }

    public function postEmployer(array $data){
        $employer = $data;

        $errors = $this->validator->validate($employer);
        if ($errors->count() > 0) {
            $this->getLogger()->warning("Employer validation failed", [
                "errors" => $errors,
                "employer" => $employer
            ]);
            return false;
        }
    }

    private function assembleEmployer(array $data): Employer{
        $employer = new Employer();
        $employer->setName($data["name"]);
        $employer->setAddress($data["address"]);
        $employer->setFormOfCare($data["form_of_care"]);
        $employer->setProviderType($data["provider_type"]);

        return $employer;
    }

}