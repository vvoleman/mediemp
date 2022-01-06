<?php

namespace App\Email\Employer;

use App\Entity\Employer;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mime\Header\Headers;
use Symfony\Component\Mime\Part\AbstractPart;

class EmployerCreatedEmail extends TemplatedEmail {

    public function __construct(Employer $employer,Headers $headers = null, AbstractPart $body = null) {
        parent::__construct($headers, $body);

        $this->htmlTemplate("email/employer/created.html.twig");
        $this->context([
            "employer"=>$employer
        ]);
        $this->subject("Potvrzení nové organizace");
    }

}