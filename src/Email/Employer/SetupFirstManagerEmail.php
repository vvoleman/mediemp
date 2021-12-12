<?php

namespace App\Email\Employer;

use App\Entity\Employer;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mime\Header\Headers;
use Symfony\Component\Mime\Part\AbstractPart;

class SetupFirstManagerEmail extends TemplatedEmail {

    public function __construct(Employer $employer,Headers $headers = null, AbstractPart $body = null) {
        parent::__construct($headers, $body);

        $this->htmlTemplate("email/employer/setup_first_manager.html.twig");
        $this->context([
            "employer"=>$employer
        ]);
        $this->subject("Vytvoření manažerského účtu");
    }

}