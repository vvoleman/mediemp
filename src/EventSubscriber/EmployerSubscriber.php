<?php

namespace App\EventSubscriber;

use App\Email\Employer\EmployerConfirmedEmail;
use App\Email\Employer\EmployerCreatedEmail;
use App\Email\Employer\SetupFirstManagerEmail;
use App\Event\BugTracker\BugReportCreatedEvent;
use App\Event\Employer\EmployerConfirmedEvent;
use App\Event\Employer\EmployerCreatedEvent;
use App\Security\LoggerAwareTrait;
use App\Service\Mail\SenderService;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class EmployerSubscriber implements EventSubscriberInterface {

    use LoggerAwareTrait;

    private SenderService $sender;

    public function __construct(SenderService $sender) {
        $this->sender = $sender;
    }

    public static function getSubscribedEvents() {
        return [
            EmployerConfirmedEvent::class => [['sendConfirmed',10], ['sendManagerSetup',0]],
            EmployerCreatedEvent::class => [['sendCreated',10]]
        ];
    }

    public function sendConfirmed(EmployerConfirmedEvent $event) {
        $this->getLogger()->error("aaaa");
        $email = (new EmployerConfirmedEmail())
            ->to($event->getEmail());

        $this->sender->send($email);
    }

    public function sendManagerSetup(EmployerConfirmedEvent $event) {
        $email = (new SetupFirstManagerEmail($event->getEmployer()))
            ->to($event->getEmail());

        $this->sender->send($email);
    }

    public function sendCreated(EmployerCreatedEvent $event){
        $this->getLogger()->error("aaaa");
        $email = (new EmployerCreatedEmail($event->getEmployer()))
            ->to($event->getEmployer()->getConfirmEmail());

        $this->sender->send($email);
    }
}