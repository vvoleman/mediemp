<?php

namespace App\Controller\Employer;

use App\Entity\Employee;
use App\Entity\Employer;
use App\Entity\User;
use App\Event\Employer\EmployeeCreatedEvent;
use App\Event\Employer\EmployerConfirmedEvent;
use App\Form\ConfirmEmployerType;
use App\Form\NewEmployeeType;
use App\Repository\EmployeeRepository;
use App\Repository\EmployerRepository;
use App\Service\Entity\EmployeeService;
use App\Service\Util\PreviousUrlService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\{EventDispatcher\Debug\TraceableEventDispatcher,
    EventDispatcher\EventDispatcherInterface,
    HttpFoundation\RedirectResponse,
    HttpFoundation\Request,
    HttpFoundation\Response,
    PasswordHasher\Hasher\UserPasswordHasherInterface,
    Routing\Annotation\Route,
    Stopwatch\Stopwatch};

class ConfirmController extends AbstractController {

    private EntityManagerInterface $manager;
    private EventDispatcherInterface $dispatcher;

    public function __construct(EntityManagerInterface $manager, EventDispatcherInterface $dispatcher) {
        $this->manager = $manager;
        $this->dispatcher = $dispatcher;
    }

    /**
     * @Route("/auth/employer/confirm/{confirmToken}",name="app_employer_confirm")
     */
    public function confirm(Request $request, EmployerRepository $repository, string $confirmToken) {
        $employer = $repository->getUnconfirmedEmployer($confirmToken);
        if($employer->getConfirmedAt()){
            $this->addFlash("warning","Tato organizace již byla potvrzena!");
            return $this->redirectToRoute('app_home');
        }
        if (!$employer) {
            $this->createNotFoundException("Invalid token");
        }
        $form = $this->createForm(ConfirmEmployerType::class, $employer,[
            "manager_email"=>$employer->getConfirmEmail()
        ]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var Employer $employer */
            $employer = $form->getData();
            $employer->setConfirmedAt(new \DateTimeImmutable());
            $this->manager->flush();

            $this->dispatcher->dispatch(new EmployerConfirmedEvent($employer,$form['manager_email']->getNormData()));

            $this->addFlash("success","Organizace potvrzena, na email přijde link pro vytvoření manažera");
            return $this->redirectToRoute('app_home');
        } //TODO: Kontrola dat a vytvoření manažera
        return $this->renderForm("employer/confirm.html.twig", ["employer" => $employer, "employeeForm" => $form]);
    }

    #[Route("/auth/employer/confirm/{confirmToken}/setup",name:"app_employer_confirm_setup")]
    public function setupManager(Request $request, EmployerRepository $repository, string $confirmToken, EventDispatcherInterface $dispatcher, UserPasswordHasherInterface $hasher): RedirectResponse|Response {
        $employer = $repository->getUnconfirmedEmployer($confirmToken);
        if (!$employer) {
            $this->createNotFoundException("Invalid token");
        }
        if(!$employer->getManagers()->isEmpty()){
            $this->createNotFoundException("Managers already exists");
        }
        $employee = new Employee();
        $form = $this->createForm(NewEmployeeType::class, $employee);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $user = new User();
            $user->setEmail($form->get('email')->getNormData());
            $user->setPassword($hasher->hashPassword($user,$form->get('password')->getNormData()));
            $user->setType(Employee::TYPE_NAME);
            $this->manager->persist($user);

            /** @var Employee $employee */
            $employee = $form->getData();
            $employee->setEmployer($employer);
            $employee->setManaging($employer);
            $employee->setIdentity($user);

            $this->manager->persist($employee);
            $this->manager->flush();

            $this->addFlash("success","Manažerský účet vytvořen!");
            return $this->redirectToRoute("app_home");
        }

        return $this->renderForm('employer/setup_manager.html.twig',[
            'form'=>$form,
            "employer"=>$employer
        ]);
    }

    #[Route("/auth/employee/setup/{confirmToken}",name:"app_employee_setup")]
    public function setupEmployee(Request $request,EmployeeRepository $repository, string $confirmToken, UserPasswordHasherInterface $hasher) {
        $employee = $repository->findOneBy(["confirmToken"=>$confirmToken]);

        if(!$employee){
            throw $this->createNotFoundException("No employee associated with this token");
        }
        if($employee->getConfirmedAt() || $employee->getIdentity()){
            throw $this->createNotFoundException("This employee has already been set up");
        }

        $form = $this->createForm(NewEmployeeType::class,null,[
            "mode"=>"only-credentials"
        ]);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $user = new User();
            $user->setEmail($form->get("email")->getNormData());
            $user->setType("employee");
            $user->setPassword($hasher->hashPassword($user, $form->get("password")->getNormData()));
            $this->manager->persist($user);
            $employee->setIdentity($user);
            $this->manager->flush();

            $this->dispatcher->dispatch(new EmployeeCreatedEvent($employee));
            $this->addFlash("success","Váš účet byl vytvořen, můžete se přihlásit!");
            return $this->redirectToRoute("app_security_employee");
        }

        return $this->renderForm('employer/setup_employee.html.twig',[
            "form"=>$form,
            "employer"=>$employee->getEmployer()
        ]);
    }
}