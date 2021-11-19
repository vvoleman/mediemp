<?php

namespace App\Controller;

use App\Entity\Employer;
use App\Form\NewEmployeeType;
use App\Repository\EmployerRepository;
use App\Service\Entity\EmployeeService;
use App\Service\Util\PreviousUrlService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/auth/employer/confirm",name="app_employer_confirm")
 */
class ConfirmEmployerController extends AbstractController {

    private PreviousUrlService $urlService;

    public function __construct(PreviousUrlService $urlService) {
        $this->urlService = $urlService;
    }

    /**
     * @Route("/{confirmToken}",methods={"GET"})
     */
    public function index(EmployerRepository $repository, string $confirmToken) {
        $employer = $repository->getUnconfirmedEmployer($confirmToken);
        if (!$employer) {
            $this->createNotFoundException("Invalid token");
        }

        //TODO: Kontrola dat a vytvoření manažera
        return $this->renderForm("employer/confirm.html.twig", [
            "employer" => $employer
        ]);
    }

    /**
     * @Route("/{confirmToken}",name="_post",methods={"POST"})
     */
    public function post(string $token, EmployerRepository $repository, Request $request, EmployeeService $employeeService){
        $employer = $repository->getUnconfirmedEmployer($token);
        if (!$employer) {
            $this->addFlash("error", "Nepotvrzeno, potvrzovací token není platný");
            return new RedirectResponse($this->generateUrl($this->urlService->get("app_home")));
        }

        $employeeService->postEmployee($request->request->all(),$employer);
        $this->addFlash("success","Organizace byla potvrzena, manažerovi byl zaslán e-mail k registraci");
        //TODO: Odešli mail o vytvoření manažerovi
        return new RedirectResponse($this->generateUrl("app_home"));
    }

}