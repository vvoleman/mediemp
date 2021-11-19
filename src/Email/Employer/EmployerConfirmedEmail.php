<?php

namespace App\Email\Employer;

use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mime\Header\Headers;
use Symfony\Component\Mime\Part\AbstractPart;

class EmployerConfirmedEmail extends TemplatedEmail {

    public function __construct(Headers $headers = null, AbstractPart $body = null) {
        parent::__construct($headers, $body);

        $this->htmlTemplate("email/employer/confirmed.html.twig");
        $this->subject("Organizace potvrzena");
    }

}