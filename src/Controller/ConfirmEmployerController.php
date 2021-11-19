<?php

namespace App\Controller;

use App\Entity\Employee;
use App\Entity\Employer;
use App\Event\Employer\EmployerConfirmedEvent;
use App\Form\NewEmployeeType;
use App\Repository\EmployerRepository;
use App\Service\Entity\EmployeeService;
use App\Service\Util\PreviousUrlService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\{EventDispatcher\EventDispatcherInterface, HttpFoundation\Request, Routing\Annotation\Route};

/**
 * @Route("/auth/employer/confirm",name="app_employer_confirm")
 */
class ConfirmEmployerController extends AbstractController {

    private PreviousUrlService $urlService;

    public function __construct(PreviousUrlService $urlService) {
        $this->urlService = $urlService;
    }

    /**
     * @Route("/{confirmToken}")
     */
    public function index(Request                  $request, EmployerRepository $repository,
                          EntityManagerInterface   $manager,
                          string                   $confirmToken,
                          EventDispatcherInterface $dispatcher
    ) {
        $employer = $repository->getUnconfirmedEmployer($confirmToken);
        if (!$employer) {
            $this->createNotFoundException("Invalid token");
        }

        $employee = new Employee();
        $form = $this->createForm(NewEmployeeType::class, $employee);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $email = $form->get('email')->getNormData();

            /** @var Employee $employee */
            $employee = $form->getData();
            $employee->setEmployer($employer);

            $dispatcher->dispatch(new EmployerConfirmedEvent($employee, $email));

            dd($employee);
        }

        //TODO: Kontrola dat a vytvoření manažera
        return $this->renderForm("employer/confirm.html.twig", [
            "employer" => $employer,
            "employeeForm" => $form
        ]);
    }

    /**
     * @Route("/{confirmToken}",name="_post",methods={"POST"})
     */
    /*public function post(string $token, EmployerRepository $repository, Request $request, EmployeeService $employeeService){
        $employer = $repository->getUnconfirmedEmployer($token);
        if (!$employer) {
            $this->addFlash("error", "Nepotvrzeno, potvrzovací token není platný");
            return new RedirectResponse($this->generateUrl($this->urlService->get("app_home")));
        }

        $employeeService->postEmployee($request->request->all(),$employer);
        $this->addFlash("success","Organizace byla potvrzena, manažerovi byl zaslán e-mail k registraci");
        //TODO: Odešli mail o vytvoření manažerovi
        return new RedirectResponse($this->generateUrl("app_home"));
    }*/

}