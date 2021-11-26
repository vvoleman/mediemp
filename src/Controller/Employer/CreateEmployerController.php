<?php

namespace App\Controller\Employer;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CreateEmployerController extends AbstractController
{
    #[Route('/employer/create/', name: 'app_employer_create')]
    public function index(): Response {
        return $this->render('employer/create_employer/index.html.twig', [
            'controller_name' => 'CreateEmployerController',
        ]);
    }
}
