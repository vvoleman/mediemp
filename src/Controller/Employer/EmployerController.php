<?php

namespace App\Controller\Employer;

use App\Entity\CourseAppointment;
use App\Entity\Employee;
use App\Entity\Employer;
use App\Event\Employer\EmployeeDeletedEvent;
use App\Event\Employer\EmployeeSetupEvent;
use App\Form\ExportDataType;
use App\Form\NewEmployeeType;
use App\Service\Entity\EntityExports\Employee\EmployeeBasicExport;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use League\Csv\Writer;

#[IsGranted("EMPLOYEE_IS_MANAGER")]
#[Route("/employer",name:"app_employer")]
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
    public function employeesList(): Response {
        $user = $this->getUser()->getUser();
        $employer = $user->getManaging();
        $employees = $employer->getEmployees();

        return $this->render('employer/list_employees.html.twig',[
            "employees"=>$employees
        ]);
    }

    #[Route('/employees/new',name:'_employees_new')]
    public function newEmployee(Request $request,EntityManagerInterface $entityManager,EventDispatcherInterface $dispatcher): Response {
        $user = $this->getUser()->getUser();

        $employee = new Employee();
        $employee->setEmployer($user->getManaging());
        $form = $this->createForm(NewEmployeeType::class,$employee,[
            "mode"=>"only-data"
        ]);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            /** @var Employee $employee */
            $employee = $form->getData();
            $email = $form["email"]->getNormData();
            $employee->setConfirmToken(md5($email.uniqid()));

            $entityManager->persist($employee);
            $entityManager->flush();

            $dispatcher->dispatch(new EmployeeSetupEvent($employee,$email));

            $this->addFlash("success","Zaměstnanec byl vytvořen. Na e-mail mu byl zaslán link pro vytvoření přihlašovacích údajů");
        }

        return $this->renderForm("employer/new_employee.html.twig",[
            "form"=>$form
        ]);
    }

    #[Route("/export",name:'_export')]
    public function exportData(Request $request,EmployeeBasicExport $export): Response {
        $form = $this->createForm(ExportDataType::class);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $user = $this->getUser()->getUser();
            /** @var Employer $employer */
            $employer = $user->getManaging();
            $employees = $employer->getEmployees();
            $arr = $export->exportMany($employees->toArray());
            $keys = $export->getKeys();
            $name = sprintf("%s_employees",(new \DateTime())->format("Y-m-d_H:is"));

            switch ($form->get("type")->getViewData()){
                case "csv":
                    return $this->generateCsv($keys,$arr,$name);
                case "json":
                    return $this->generateJson($arr,$name);
            }

        }

        return $this->renderForm('employer/export_data.html.twig',[
            "form"=>$form
        ]);
    }

    #[Route("/delete/{id}",name: "_delete")]
    public function deleteEmployee(Request $request, Employee $employee, EntityManagerInterface $manager, EventDispatcherInterface $dispatcher){
        $form = $this->createFormBuilder()
            ->add("confirm",SubmitType::class,["label"=>"Smazat"])
            ->add("_id",HiddenType::class,["data"=>$employee->getId()])
            ->getForm();

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $data = $form->getData();
            if($data["_id"] != $employee->getId()){
                $this->addFlash("danger","Zadané parametry se neshodují, zkuste to znovu");
            }else{
                $deletedId = $employee->getId();
                $manager->remove($employee);
                $manager->flush();
                $dispatcher->dispatch(new EmployeeDeletedEvent($employee));
                $this->addFlash("success",sprintf("Uživatel s ID:%d smazán!",$deletedId));

                return $this->redirectToRoute("app_employer_employees");
            }
            //smazat employeeho
            //odeslat email

        }

        return $this->renderForm("employer/delete.html.twig",[
            "form"=>$form,
            "employee"=>$employee
        ]);
    }

    private function generateCsv(array $keys, array $data, string $name, string $delimiter = " "): Response{
        $data = array_map(function($x){
            return array_values($x);
        },$data);
        $csv = Writer::createFromString();
        $csv->insertOne($keys);
        $csv->insertAll($data);
        $csv->setDelimiter($delimiter);

        $response = new Response($csv->toString());
        $response->headers->set('Content-Encoding', 'UTF-8');
        $response->headers->set('Content-Type', 'text/csv; charset=UTF-8');
        $response->headers->set('Content-Disposition', sprintf('attachment; filename=%s.csv',$name));
        return $response;
    }

    private function generateJson(array $data, string $name): Response{
        $jsonResponse = new JsonResponse($data);
        $jsonResponse->headers->set('Content-Encoding', 'UTF-8');
        $jsonResponse->headers->set('Content-Type', 'text/csv; charset=UTF-8');
        $jsonResponse->headers->set('Content-Disposition',sprintf('attachment; filename=%s.json',$name));
        return $jsonResponse;
    }
}
