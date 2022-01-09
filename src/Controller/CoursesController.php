<?php

namespace App\Controller;

use App\Entity\CourseAppointment;
use App\Entity\CourseRegistration;
use App\Entity\Employee;
use App\Entity\EmployerCourse;
use App\Entity\GlobalCourse;
use App\Form\AdoptCourseType;
use App\Form\NewAppointmentType;
use App\Repository\CourseAppointmentRepository;
use App\Repository\CourseRegistrationRepository;
use App\Repository\EmployeeRepository;
use App\Repository\EmployerCourseRepository;
use App\Repository\EmployerRepository;
use App\Repository\GlobalCourseRepository;
use App\Security\VerifyCsrfTrait;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

//TODO: #[IsGranted("USER_EMPLOYEE")]
#[Route("/courses",name:"app_courses")]
class CoursesController extends AbstractController {

    use VerifyCsrfTrait;

    #[Route("/",name:"",methods: ["GET"])]
    public function index(): Response {
        /** @var Employee $user */
        $user = $this->getUser()->getUser();
        $records = $user->getEmployer()->getEmployerCourses();
        return $this->render('courses/index.html.twig', [
            'courses' => $records
        ]);
    }

    #[Route("/adopt",name:"_adopt")]
    public function create(Request $request,EntityManagerInterface $entityManager): Response {
        //TODO: $this->denyAccessUnlessGranted("EMPLOYEE_IS_MANAGER");
        //adopt
//        return $this->;
        /** @var Employee $user */
        $user = $this->getUser()->getUser();
        $form = $this->createForm(AdoptCourseType::class,null,["employer_id"=>$user->getEmployer()->getId()]);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $course = $form->get("course")->getNormData();
            $employerCourse = new EmployerCourse();
            $employerCourse->setEmployer($user->getEmployer());
            $employerCourse->setCourse($course);
            $entityManager->persist($employerCourse);
            $entityManager->flush();

            $this->addFlash("success","Kurz byl adoptován!");
            //TODO: přesměruj na detaily kurzu
        }

        return $this->renderForm("courses/adopt.html.twig",[
            "form"=>$form
        ]);
    }

    #[Route("/{id}",name:"_details")]
    public function detailsManager(Request $request, EmployerCourse $c, EntityManagerInterface $entityManager): Response {
        //TODO: $this->denyAccessUnlessGranted("EMPLOYEE_IS_MANAGER_OF",$c->getEmployer());

        $appointment = new CourseAppointment();
        $newAppointmentForm = $this->createForm(NewAppointmentType::class,$appointment);

        $newAppointmentForm->handleRequest($request);
        if($newAppointmentForm->isSubmitted() && $newAppointmentForm->isValid()){
            /** @var CourseAppointment $appointment */
            $appointment = $newAppointmentForm->getNormData();
            $appointment->setEmployerCourse($c);
            $entityManager->persist($appointment);
            $entityManager->flush();
            $this->addFlash("success","Nový termín přidán!");
        }

        return $this->renderForm('courses/one.html.twig', [
            'course' => $c->getCourse(),
            'emp_course' => $c,
            "new_appointment"=>$newAppointmentForm
        ]);
    }

    #[Route("/{id}/employee",name:"_details_employee")]
    public function detailsEmployee(Request $request, EmployerCourse $course, CourseAppointmentRepository $repository, EntityManagerInterface $entityManager): Response {
        if($request->request->get("_submit")){
            if (!$this->verify("join-appointment",$request->request->get("_csrf"))){
                throw new \Exception("Outdated request",419);
            }

            $id = $request->request->get("_appointment_id");
            $appointment = $repository->find($id);
            if($appointment->canEnter()){
                $registration = new CourseRegistration();

                /** @var Employee $user */
                $user = $this->getUser()->getUser();
                $registration->setEmployee($user);
                $registration->setCourseAppointment($appointment);
                $entityManager->persist($registration);
                $entityManager->flush();

                $this->addFlash("success","Úspěšně přihlášeno na termín!");
            }else{
                $this->addFlash("danger","Termín je již plný!");
            }
        }

        return $this->render("courses/one_employee.html.twig",[
            "employer_course"=>$course,
            "course"=>$course->getCourse()
        ]);
    }

    /**
     * @Route("/courses/{id}", name="app_courses_one_post",methods={"POST"})
     */
    public function indexOneCoursePost(GlobalCourse $c, Request $request, $id, EmployerRepository $emp, EmployerCourseRepository $emp_course, CourseAppointmentRepository $course_appointemtn): Response {
        if ($request->request->get('action') == "edit_course") {
            $entityManager = $this->getDoctrine()->getManager();
            $c->setName($request->request->get('name'));
            $c->setFocus($request->request->get('focus'));
            $c->setSpecialization($request->request->get('specialization'));
            $c->setKeywords($request->request->get('keywords'));
            $entityManager->persist($c);
            $entityManager->flush();
            $this->addFlash("success", "Uloženo");
        } else if ($request->request->get('action') == "adopt_course") {
            $entityManager = $this->getDoctrine()->getManager();
            $new = new EmployerCourse();
            $new->setEmployer($emp->findOneBy(['id' => $request->request->get("employer_id")]));
            $new->setCourse($c);
            $entityManager->persist($new);
            $entityManager->flush();
            $this->addFlash("success", "Kurz adoptován");
        } else if ($request->request->get('action') == "create_appointment") {
            $entityManager = $this->getDoctrine()->getManager();
            $new = new CourseAppointment();
            $new->setEmployerCourse($emp_course->findOneBy(['id' => $request->request->get("id")]));
            $new->setDate(new DateTime(date("Y-m-d H:i:s", strtotime($request->request->get('date')))));
            $new->setPlace($request->request->get('place'));
            $new->setCapacity($request->request->get('capacity'));
            $entityManager->persist($new);
            $entityManager->flush();
            $this->addFlash("success", "Termín vytvořen");
        } else if ($request->request->get('action') == "delete_appointment") {
            $entityManager = $this->getDoctrine()->getManager();
            $old = $course_appointemtn->findOneBy(['id' => $request->request->get("id")]);
            $entityManager->remove($old);
            $entityManager->flush();
            $this->addFlash("success", "Termín smazán");
        }
        return new RedirectResponse($this->generateUrl("app_courses_one", ['id' => $id]));
    }

    /**
     * @Route("/courses/{c_id}/appointment/{id}", name="app_courses_one_appointment",methods={"GET"})
     */
    public function indexAppointment(CourseAppointment $c, EmployeeRepository $emp): Response {
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
    public function indexAppointmentPost(CourseAppointment $c, Request $request, $c_id, $id, CourseRegistrationRepository $rep_c, EmployeeRepository $emp): Response {
        if ($request->request->get('action') == "edit_course") {
            $entityManager = $this->getDoctrine()->getManager();
            $c->setDate(new DateTime(date("Y-m-d H:i:s", strtotime($request->request->get('date')))));
            $c->setPlace($request->request->get('place'));
            $c->setCapacity($request->request->get('capacity'));
            $entityManager->persist($c);
            $entityManager->flush();
            $this->addFlash("success", "Uloženo");
        } else if ($request->request->get('action') == "set_test_done") {
            $entityManager = $this->getDoctrine()->getManager();
            $old = $rep_c->findOneBy(['id' => $request->request->get("id")]);
            $old->setTestDone(1);
            $entityManager->persist($old);
            $entityManager->flush();
            $this->addFlash("success", "Test označen za hotový");
        } else if ($request->request->get('action') == "set_absent") {
            $entityManager = $this->getDoctrine()->getManager();
            $old = $rep_c->findOneBy(['id' => $request->request->get("id")]);
            $old->setAbsence(1);
            $entityManager->persist($old);
            $entityManager->flush();
            $this->addFlash("success", "Uživatel chyběl");
        } else if ($request->request->get('action') == "remove") {
            $entityManager = $this->getDoctrine()->getManager();
            $old = $rep_c->findOneBy(['id' => $request->request->get("id")]);
            $entityManager->remove($old);
            $entityManager->flush();
            $this->addFlash("success", "Uživatel odebrán");
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
            $this->addFlash("success", "Uživatel přidán");
        }
        return new RedirectResponse($this->generateUrl("app_courses_one_appointment", ['id' => $id, 'c_id' => $c_id]));
    }
}
