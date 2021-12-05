<?php

namespace App\Controller\Employer;

use App\Entity\Employee;
use App\Entity\Employer;
use App\Entity\User;
use App\Event\Employer\EmployerConfirmedEvent;
use App\Form\ConfirmEmployerType;
use App\Form\NewEmployeeType;
use App\Repository\EmployerRepository;
use App\Service\Entity\EmployeeService;
use App\Service\Util\PreviousUrlService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\{EventDispatcher\Debug\TraceableEventDispatcher,
    EventDispatcher\EventDispatcherInterface,
    HttpFoundation\Request,
    PasswordHasher\Hasher\UserPasswordHasherInterface,
    Routing\Annotation\Route,
    Stopwatch\Stopwatch};

/**
 * @Route("/auth/employer/confirm",name="app_employer_confirm")
 */
class ConfirmEmployerController extends AbstractController {

    /**
     * @Route("/{confirmToken}",name="")
     */
    public function confirm(Request $request, EmployerRepository $repository, EntityManagerInterface $manager, string $confirmToken, EventDispatcherInterface $dispatcher) {
        $employer = $repository->getUnconfirmedEmployer($confirmToken);
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
            $manager->flush();

            $dispatcher->dispatch(new EmployerConfirmedEvent($employer,$form['manager_email']->getNormData()));

            $this->addFlash("success","Organizace potvrzena, na email přijde link pro vytvoření manažera");
        } //TODO: Kontrola dat a vytvoření manažera
        return $this->renderForm("employer/confirm.html.twig", ["employer" => $employer, "employeeForm" => $form]);
    }

    #[Route("/{confirmToken}/setup",name:"_setup")]
    public function setupManager(Request $request, EmployerRepository $repository, EntityManagerInterface $manager, string $confirmToken, EventDispatcherInterface $dispatcher, UserPasswordHasherInterface $hasher){
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
            $manager->persist($user);

            /** @var Employee $employee */
            $employee = $form->getData();
            $employee->setEmployer($employer);
            $employee->setIdentity($user);

            //$dispatcher->dispatch(new EmployerConfirmedEvent($employee, $email));

            $manager->persist($employee);
            $manager->flush();

            $this->addFlash("success","Manažerský účet vytvořen!");
            return $this->redirectToRoute("app_home");
        }

        return $this->renderForm('employer/setup.html.twig',[
            'form'=>$form,
            "employer"=>$employer
        ]);
    }

}