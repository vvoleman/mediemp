<?php

namespace App\Event\BugTracker;

use App\Entity\Bug;
use Symfony\Contracts\EventDispatcher\Event;

class BugReportCreatedEvent extends Event {

    public const NAME = 'bugreport.created';
    private Bug $bug;

    public function __construct(Bug $bug) {
        $this->bug = $bug;
    }

    public function getBug(): Bug {
        return $this->bug;
    }


}