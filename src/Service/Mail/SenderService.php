<?php

namespace App\Service\Mail;

use App\Security\LoggerAwareTrait;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class SenderService {
    use LoggerAwareTrait;
    private MailerInterface $mailer;

    public function __construct(MailerInterface $mailer) {
        $this->mailer = $mailer;
    }

    public function send(Email $email) {
        try {
            $this->mailer->send($email);
        } catch (TransportExceptionInterface $e) {
            $this->getLogger()->error("E-mail couldn't be sent", [
                "exception" => $e,
                "email" => $email,
            ]);
        }
    }

}