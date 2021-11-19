<?php

namespace App\EventSubscriber;

use App\Email\Employer\EmployerConfirmedEmail;
use App\Email\Employer\SetupFirstManagerEmail;
use App\Event\BugTracker\BugReportCreatedEvent;
use App\Event\Employer\EmployerConfirmedEvent;
use App\Security\LoggerAwareTrait;
use App\Service\Mail\SenderService;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class EmployerSubscriber implements EventSubscriberInterface {

    use LoggerAwareTrait;

    private SenderService $sender;

    public function __construct(SenderService $sender) {
        $this->sender = $sender;
    }

    public static function getSubscribedEvents() {
        return [
            EmployerConfirmedEvent::NAME => [['sendConfirmed'], ['sendManagerSetup']]
        ];
    }

    public function sendConfirmed(EmployerConfirmedEvent $event) {
        $this->getLogger()->error("aaaa");
        $email = (new EmployerConfirmedEmail())
            ->to($event->getEmail());

        $this->sender->send($email);
    }

    public function sendManagerSetup(EmployerConfirmedEvent $event) {
        $email = (new SetupFirstManagerEmail())
            ->to($event->getEmail());

        $this->sender->send($email);
    }
}