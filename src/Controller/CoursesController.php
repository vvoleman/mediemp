<?php

namespace App\Controller;

use App\Entity\CourseAppointment;
use App\Entity\EmployerCourse;
use App\Entity\GlobalCourse;
use App\Repository\EmployerCourseRepository;
use App\Repository\GlobalCourseRepository;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Doctrine\ORM\Mapping\Id;
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


    /**
     * @Route("/courses/{id}", name="app_courses_one",methods={"GET"})
     */
    public function index2(GlobalCourseRepository $repository, GlobalCourse $c): Response
    {
        $courses = $c->getEmployerCourses()->toArray();
        return $this->render('courses/one.html.twig', [
            'controller_name' => 'CoursesController',
            'course' => $c,
            'emp_course' => $courses,
        ]);
    }
    /**
     * @Route("/courses/{id}", name="app_courses_one",methods={"POST"})
     */
    public function index2Post(GlobalCourseRepository $repository, GlobalCourse $c): Response
    {

        $url = $this->previousUrlService->get();
        if (!$url) {
            $url = $this->generateUrl("app_home");
        }

        return new RedirectResponse($url);
    }


    #[Route('/courses/{c_id}/appointment/{id}', name: 'app_courses_one_appointment')]
    public function indexAppointment(CourseAppointment $c): Response
    {
        $course = $c->getEmployerCourse()->getCourse();
        $peoples = $c->getCourseRegistrations()->toArray();

        return $this->render('courses/appointment.html.twig', [
            'controller_name' => 'CoursesController',
            'course' => $course,
            'peoples' => $peoples,
            'appointment' => $c

        ]);
    }
}
