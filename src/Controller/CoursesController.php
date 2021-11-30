<?php

namespace App\Controller;

use App\Entity\CourseAppointment;
use App\Entity\CourseRegistration;
use App\Entity\EmployerCourse;
use App\Entity\GlobalCourse;
use App\Repository\CourseAppointmentRepository;
use App\Repository\CourseRegistrationRepository;
use App\Repository\EmployeeRepository;
use App\Repository\EmployerCourseRepository;
use App\Repository\EmployerRepository;
use App\Repository\GlobalCourseRepository;
use App\Service\Util\PreviousUrlService;
use DateTime;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Doctrine\ORM\Mapping\Id;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CoursesController extends AbstractController
{
    #[Route('/courses', name: 'app_courses')]
    public function indexCourses(GlobalCourseRepository $repository): Response
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
    public function indexOneCourse(EmployerRepository $em, GlobalCourse $c): Response
    {
        $all_emplyers = $em->findAll();
        $courses = $c->getEmployerCourses()->toArray();
        return $this->render('courses/one.html.twig', [
            'controller_name' => 'CoursesController',
            'course' => $c,
            'emp_course' => $courses,
            "emp_all" => $all_emplyers
        ]);
    }
    /**
     * @Route("/courses/{id}", name="app_courses_one_post",methods={"POST"})
     */
    public function indexOneCoursePost(GlobalCourse $c, Request $request, $id, EmployerRepository $emp, EmployerCourseRepository $emp_course, CourseAppointmentRepository $course_appointemtn): Response
    {
        if ($request->request->get('action') == "edit_course") {
            $entityManager = $this->getDoctrine()->getManager();
            $c->setName($request->request->get('name'));
            $c->setFocus($request->request->get('focus'));
            $c->setSpecialization($request->request->get('specialization'));
            $c->setKeywords($request->request->get('keywords'));
            $entityManager->persist($c);
            $entityManager->flush();
            $this->addFlash("success", "Data saved");
        } else if ($request->request->get('action') == "adopt_course") {
            $entityManager = $this->getDoctrine()->getManager();
            $new = new EmployerCourse();
            $new->setEmployer($emp->findOneBy(['id' => $request->request->get("employer_id")]));
            $new->setCourse($c);
            $entityManager->persist($new);
            $entityManager->flush();
            $this->addFlash("success", "Course addopted");
        } else if ($request->request->get('action') == "create_appointment") {
            $entityManager = $this->getDoctrine()->getManager();
            $new = new CourseAppointment();
            $new->setEmployerCourse($emp_course->findOneBy(['id' => $request->request->get("id")]));
            $new->setDate(new DateTime());
            $new->setCapacity(0);
            $new->setPlace("");
            $entityManager->persist($new);
            $entityManager->flush();
            $this->addFlash("success", "Course addopted");
        } else if ($request->request->get('action') == "delete_appointment") {
            $entityManager = $this->getDoctrine()->getManager();
            $old = $course_appointemtn->findOneBy(['id' => $request->request->get("id")]);
            $entityManager->remove($old);
            $entityManager->flush();
            $this->addFlash("success", "Course addopted");
        }
        return new RedirectResponse($this->generateUrl("app_courses_one", ['id' => $id]));
    }

    /**
     * @Route("/courses/{c_id}/appointment/{id}", name="app_courses_one_appointment",methods={"GET"})
     */
    public function indexAppointment(CourseAppointment $c, EmployeeRepository $emp): Response
    {
        $course = $c->getEmployerCourse()->getCourse();
        $peoples = $c->getCourseRegistrations()->toArray();
        $all_users = $emp->findAll();
        return $this->render('courses/appointment.html.twig', [
            'controller_name' => 'CoursesController',
            'course' => $course,
            'peoples' => $peoples,
            'appointment' => $c,
            'all_users' => $all_users

        ]);
    }
    /**
     * @Route("/courses/{c_id}/appointment/{id}", name="app_courses_one_appointment_post",methods={"POST"})
     */
    public function indexAppointmentPost(CourseAppointment $c, Request $request, $c_id, $id, CourseRegistrationRepository $rep_c, EmployeeRepository $emp): Response
    {
        if ($request->request->get('action') == "edit_course") {
            $entityManager = $this->getDoctrine()->getManager();
            $c->setDate(new DateTime(date("Y-m-d H:i:s", strtotime($request->request->get('date')))));
            $c->setPlace($request->request->get('place'));
            $c->setCapacity($request->request->get('capacity'));
            $entityManager->persist($c);
            $entityManager->flush();
            $this->addFlash("success", "Data saved");
        } else if ($request->request->get('action') == "set_test_done") {
            $entityManager = $this->getDoctrine()->getManager();
            $old = $rep_c->findOneBy(['id' => $request->request->get("id")]);
            $old->setTestDone(1);
            $entityManager->persist($old);
            $entityManager->flush();
            $this->addFlash("success", "Test market as done");
        } else if ($request->request->get('action') == "set_absent") {
            $entityManager = $this->getDoctrine()->getManager();
            $old = $rep_c->findOneBy(['id' => $request->request->get("id")]);
            $old->setAbsence(1);
            $entityManager->persist($old);
            $entityManager->flush();
            $this->addFlash("success", "User marked absent");
        } else if ($request->request->get('action') == "remove") {
            $entityManager = $this->getDoctrine()->getManager();
            $old = $rep_c->findOneBy(['id' => $request->request->get("id")]);
            $entityManager->remove($old);
            $entityManager->flush();
            $this->addFlash("success", "User removed");
        } else if ($request->request->get('action') == "add_user") {
            $entityManager = $this->getDoctrine()->getManager();
            $new = new CourseRegistration();
            $new->setCourseAppointment($c);
            $new->setEmployee($emp->findOneBy(['id' => $request->request->get("id")]));
            $new->setAbsence(0);
            $new->setTestDone(0);
            $new->setNotificationStatus("pending");
            $entityManager->persist($new);
            $entityManager->flush();
            $this->addFlash("success", "User removed");
        }
        return new RedirectResponse($this->generateUrl("app_courses_one_appointment", ['id' => $id, 'c_id' => $c_id]));
    }
}
