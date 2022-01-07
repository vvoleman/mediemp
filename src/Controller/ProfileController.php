<?php

namespace App\Controller;

use App\Entity\Employee;
use App\Entity\User;
use App\Form\EditEmployeeType;
use App\Repository\EmployeeRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @IsGranted("IS_AUTHENTICATED_REMEMBERED")
 */
#[Route("/profile", name: "app_profile")]
class ProfileController extends AbstractController {

    #[Route("/{id?}", name: "_get")]
    public function index(EmployeeRepository $repository, ?Employee $employee): Response {
        $isManager = false;
        /** @var Employee $manager */
        $user = $this->getUser();
        $manager = $user->getUser();
        if ($employee && $manager->getId() != $employee->getId()) {
            if ($this->isGranted("EMPLOYEE_IS_MANAGER_OF", $employee->getEmployer())) {
                if (!$manager->getManaging()->getEmployees()->containsKey($employee)) {
                    throw $this->createAccessDeniedException("You are not able to view this employee!");
                }
            }
            $isManager = true;
            $user = $repository->find($employee);
        } else {
            $user = $this->getUser();
            $user = $user->getUser();
        }
        /** @var User $user */

        return $this->render('profile/index.html.twig', [
            'user' => $user,
            'isManager' => $isManager
        ]);
    }

    #[Route("/edit", name: "_edit")]
    public function edit(Request $request) {
        $user = $this->getUser();
        $user = $user->getUser();

        $form = $this->createForm(EditEmployeeType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            dd($data);
        }

        return $this->renderForm("profile/edit.html.twig", [
            "form" => $form
        ]);
    }

}
