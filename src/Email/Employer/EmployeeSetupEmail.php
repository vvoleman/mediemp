<?php

namespace App\Email\Employer;

use App\Entity\Employee;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mime\Header\Headers;
use Symfony\Component\Mime\Part\AbstractPart;

class EmployeeSetupEmail extends TemplatedEmail {

    public function __construct(Employee $employee, Headers $headers = null, AbstractPart $body = null) {
        parent::__construct($headers, $body);

        $this->htmlTemplate("email/employer/confirmed.html.twig");
        $this->context([
            "employee" => $employee
        ]);
        $this->subject("Organizace potvrzena");
    }

}