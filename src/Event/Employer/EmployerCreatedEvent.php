<?php

namespace App\Event\Employer;

use App\Entity\Employer;
use Symfony\Contracts\EventDispatcher\Event;

class EmployerCreatedEvent extends Event {

    public const NAME = "employer.created";
    private Employer $employer;

    public function __construct(Employer $employer) { $this->employer = $employer; }

    public function getEmployer(): Employer {
        return $this->employer;
    }
}