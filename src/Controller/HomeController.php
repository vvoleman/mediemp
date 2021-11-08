<?php

namespace App\Controller;

use App\Entity\Employee;
use App\Repository\EmployerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="app_home")
     */
    public function index(EmployerRepository $repository): Response
    {
        return $this->render('home/index.html.twig');
    }

    public function renderFlashMessages(){
        return $this->render("partials/_flashmessages.html.twig",[
            "classes"=>[
                "error"=>"danger",
                "success"=>"success",
                "info"=>"info",
                "warning"=>"warning"
            ]
        ]);
    }
}
