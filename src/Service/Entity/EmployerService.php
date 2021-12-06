<?php

namespace App\Service\Entity;

use App\Entity\Employee;
use App\Entity\Employer;
use App\Repository\EmployerLineRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class EmployerService {

    private EntityManagerInterface $entityManager;
    private ValidatorInterface $validator;
    private EmployerLineRepository $repository;

    public function __construct(EntityManagerInterface $entityManager,
                                ValidatorInterface     $validator,
                                EmployerLineRepository $repository
    ) {
        $this->entityManager = $entityManager;
        $this->validator = $validator;
        $this->repository = $repository;
    }

    public function postEmployer(array $data): false|Employer {
        $employer = $this->assembleEmployer($data);

        $errors = $this->validator->validate($employer);
        if ($errors->count() > 0) {
            $this->getLogger()->warning("Employer validation failed", [
                "errors" => $errors,
                "employer" => $employer
            ]);
            return false;
        }
        $this->entityManager->persist($employer);
        $this->entityManager->flush();
        return $employer;
    }

    private function assembleEmployer(array $data): Employer {
        $employer = new Employer();
        $employer->setName($data["name"]);
        $employer->setAddress($data["address"]);
        $employer->setFormOfCare($data["form_of_care"]);
        $employer->setProviderType($data["provider_type"]);
        $employer->setConfirmToken(md5(time() . uniqid()));
        $employer->setConfirmEmail($data["confirm_email"]);
        //$employer->setLineId($this->repository->find($data["line_id"]));

        return $employer;
    }

}