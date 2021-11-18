<?php

namespace App\Service\Entity;

use App\Entity\Employee;
use App\Entity\Employer;
use Doctrine\ORM\EntityManagerInterface;

class EmployerService {

    public function __construct(EntityManagerInterface $entityManager) {

    }

    public function postEmployer(array $data){

    }

//    private function assembleEmployer(array $data): Employer{
//        $employer = new Employer();
//        $employer->setName($data["name"]);
//        $employer->setAddress($data["address"]);
//        $employer->setFormOfCare($data["form_of_care"]);
//        $employer->setProviderType($data["provider_type"]);
//
//        //TODO: přidej manažera k zaměstnanci
//        //Nejdřív by ale asi bylo dobrý přidávání zaměstnanců - přijde email a vytvoř si účet
//        $manager = new Employee();
//
//        $employer->addManager();
//        dd();
//        return null;
//    }

}