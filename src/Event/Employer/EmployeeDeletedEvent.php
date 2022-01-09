<?php

namespace App\Event\Employer;

use App\Entity\Employee;
use Symfony\Contracts\EventDispatcher\Event;

class EmployeeDeletedEvent extends Event {

    private Employee $employee;

    public function __construct(Employee $employee) {
        $this->employee = $employee;
    }

    public function getEmployee(): Employee {
        return $this->employee;
    }

}