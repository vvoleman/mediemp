<?php

namespace App\Controller;

use App\Entity\GlobalCourse;
use App\Repository\GlobalCourseRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CoursesController extends AbstractController
{
    #[Route('/courses', name: 'app_courses')]
    public function index(GlobalCourseRepository $repository): Response
    {

        $records = $repository->findAll();
        return $this->render('courses/index.html.twig', [
            'controller_name' => 'CoursesController',
            'courses' => $records
        ]);
    }

    #[Route('/courses/{id}', name: 'app_courses_one')]
    public function index2(GlobalCourseRepository $repository, GlobalCourse $c): Response
    {

        return $this->render('courses/one.html.twig', [
            'controller_name' => 'CoursesController',
            'course' => $c
        ]);
    }
}
