<?php

namespace App\Controller\Employer;

use App\Entity\Employee;
use App\Entity\Employer;
use App\Event\Employer\EmployerConfirmedEvent;
use App\Form\NewEmployeeType;
use App\Repository\EmployerRepository;
use App\Service\Entity\EmployeeService;
use App\Service\Util\PreviousUrlService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\{EventDispatcher\Debug\TraceableEventDispatcher,
    EventDispatcher\EventDispatcherInterface,
    HttpFoundation\Request,
    Routing\Annotation\Route,
    Stopwatch\Stopwatch};

/**
 * @Route("/auth/employer/confirm",name="app_employer_confirm")
 */
class ConfirmEmployerController extends AbstractController {

    /**
     * @Route("/{confirmToken}")
     */
    public function index(Request $request, EmployerRepository $repository, EntityManagerInterface $manager, string $confirmToken, EventDispatcherInterface $dispatcher) {
        $employer = $repository->getUnconfirmedEmployer($confirmToken);
        if (!$employer) {
            $this->createNotFoundException("Invalid token");
        }
        $employee = new Employee();
        $form = $this->createForm(NewEmployeeType::class, $employee);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $email = $form->get('email')->getNormData();
            $employer->setConfirmedAt(new \DateTimeImmutable());
            /** @var Employee $employee */
            $employee = $form->getData();
            $employee->setEmployer($employer);

            $dispatcher->dispatch(new EmployerConfirmedEvent($employee, $email));

            $manager->persist($employee);
            $manager->flush();

            $this->addFlash("success","Organizace potvrzena, link pro manažerský email zaslán");
            return $this->redirectToRoute("app_home");
        } //TODO: Kontrola dat a vytvoření manažera
        return $this->renderForm("employer/confirm.html.twig", ["employer" => $employer, "employeeForm" => $form]);
    }

}