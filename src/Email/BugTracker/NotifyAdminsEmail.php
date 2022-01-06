<?php

namespace App\Email\BugTracker;

use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mime\Header\Headers;
use Symfony\Component\Mime\Part\AbstractPart;

class NotifyAdminsEmail extends TemplatedEmail {

    public function __construct(Headers $headers = null, AbstractPart $body = null) {
        parent::__construct($headers, $body);

        $this->htmlTemplate("emails/bug_tracker/notify_admins.html.twig");
        $this->subject("Nově nahlášená chyba!");
    }

}