<?php

namespace App\Event\Employer;

use App\Entity\Employee;
use Symfony\Contracts\EventDispatcher\Event;

class EmployeeCreatedEvent extends Event {

    public const NAME = "employee.created";
    private Employee $employee;

    public function __construct(Employee $employee) {
        $this->employee = $employee;
    }

    public function getEmployee(): Employee {
        return $this->employee;
    }

}