<?php

namespace App\Event\Employer;

use App\Entity\Employee;
use Symfony\Contracts\EventDispatcher\Event;

class EmployeeSetupEvent extends Event {

    public const NAME = "employee.setup";
    private Employee $employee;
    private string $email;

    public function __construct(Employee $employee, string $email) {
        $this->employee = $employee;
        $this->email = $email;
    }

    public function getEmployee(): Employee {
        return $this->employee;
    }

    public function getEmail(): string {
        return $this->email;
    }

}