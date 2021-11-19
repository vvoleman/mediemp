<?php

namespace App\Event\Employer;

use App\Entity\Employee;
use Symfony\Contracts\EventDispatcher\Event;

class EmployerConfirmedEvent extends Event {

    public const NAME = "employer.confirmed";
    private Employee $manager;
    private string $email;

    public function __construct(Employee $manager,string $email) {
        $this->manager = $manager;
        $this->email = $email;
    }

    public function getManager(): Employee {
        return $this->manager;
    }

    public function getEmail(): string {
        return $this->email;
    }

}