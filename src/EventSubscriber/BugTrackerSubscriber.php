<?php

namespace App\EventSubscriber;

use App\Event\BugTracker\BugReportCreatedEvent;

class BugTrackerSubscriber implements \Symfony\Component\EventDispatcher\EventSubscriberInterface {

    /**
     * @inheritDoc
     */
    public static function getSubscribedEvents(): array {
        return [
            BugReportCreatedEvent::NAME=>[
                ["mailAdmins"]
            ]
        ];
    }

    public function mailAdmins(){

    }
}