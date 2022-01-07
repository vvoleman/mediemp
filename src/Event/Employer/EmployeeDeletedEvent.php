<?php

namespace App\Event\Employer;

use Symfony\Contracts\EventDispatcher\Event;

class EmployeeDeletedEvent extends Event {

    private string $email;

}