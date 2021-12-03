<?php

namespace App\Event\Employer;

use App\Entity\Employee;
use App\Entity\Employer;
use Symfony\Contracts\EventDispatcher\Event;

class EmployerConfirmedEvent extends Event {

    public const NAME = "employer.confirmed";
    private Employer $employer;
    private string $email;

    public function __construct(Employer $employer,string $email) {
        $this->employer = $employer;
        $this->email = $email;
    }

    public function getEmployer(): Employer {
        return $this->employer;
    }

    public function getEmail(): string {
        return $this->email;
    }

}