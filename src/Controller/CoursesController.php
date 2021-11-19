<?php

namespace App\Controller;

use App\Entity\GlobalCourse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CoursesController extends AbstractController
{
    #[Route('/courses', name: 'courses')]
    public function index(): Response
    {
        //$global_courses = $this->get('Course')
        return $this->render('courses/index.html.twig', [
            'controller_name' => 'CoursesController',
        ]);
    }
}
