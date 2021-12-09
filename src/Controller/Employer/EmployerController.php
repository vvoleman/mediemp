<?php

namespace App\Controller\Employer;

use App\Entity\CourseAppointment;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @IsGranted("EMPLOYEE_IS_MANAGER")
 * @Route("/employer",name="app_employer")
 */
class EmployerController extends AbstractController {

    #[Route('/', name: '')]
    public function index(): Response {
        $user = $this->getUser()->getUser();
        $employer = $user->getManaging();
        $employeesCount = $employer->getEmployees()->count();

        $coursesActiveCount = 0;
        $totalAppointments = 0;
        $now = new \DateTimeImmutable();
        foreach ($employer->getEmployerCourses() as $c) {
            $arr = $c->getCourseAppointments();
            /** @var CourseAppointment $a */
            foreach ($arr as $a) {
                if ($a->getDate() > $now) $coursesActiveCount++;
            }
            $totalAppointments += $arr->count();
        }

        return $this->render('employer/index.html.twig', [
            "employeesCount" => $employeesCount,
            "activeAppointments" => $coursesActiveCount,
            "totalAppointments" => $totalAppointments
        ]);
    }

    #[Route('/employees', name: '_employees')]
    public function employeesList() {
        $user = $this->getUser()->getUser();
        $employer = $user->getManaging();
        $employees = $employer->getEmployees();

        return $this->render('employer/list_employees.html.twig',[
            "employees"=>$employees
        ]);
    }

}
