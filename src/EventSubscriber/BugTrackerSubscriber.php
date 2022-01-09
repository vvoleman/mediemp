<?php

namespace App\EventSubscriber;

use App\Email\BugTracker\NotifyAdminsEmail;
use App\Entity\Admin;
use App\Event\BugTracker\BugReportCreatedEvent;
use App\Repository\AdminRepository;
use App\Service\Mail\SenderService;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class BugTrackerSubscriber implements EventSubscriberInterface {

    private SenderService $sender;
    private AdminRepository $repository;

    public function __construct(SenderService $sender, AdminRepository $repository) {
        $this->sender = $sender;
        $this->repository = $repository;
    }

    public static function getSubscribedEvents(): array {
        return [
            BugReportCreatedEvent::NAME=>[["sendAdmins"]]
        ];
    }

    public function sendAdmins(BugReportCreatedEvent $event){
        $admins = $this->repository->findAll();

        $emails = array_map(function($x){
            /** @var Admin $x */
            return $x->getIdentity()->getEmail();
        },$admins);

        $email = (new NotifyAdminsEmail())
            ->to(...$emails);

        $this->sender->send($email);
    }
}