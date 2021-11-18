<?php

namespace App\Controller;

use App\Entity\Employer;
use App\Repository\EmployerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/auth/employer/confirm",name="app_employer_confirm")
 */
class ConfirmEmployerController extends AbstractController {

    /**
     * @Route("/{confirmToken}")
     */
    public function index(EmployerRepository $repository, string $confirmToken) {
        $employer = $repository->getUnconfirmedEmployer($confirmToken);
        if(!$employer){
            $this->createNotFoundException("Invalid token");
        }

        //TODO: Kontrola dat a vytvoření manažera
        return $this->render("employer/confirm.html.twig",[
            "employer"=>$employer
        ]);
    }

}