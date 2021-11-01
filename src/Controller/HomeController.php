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
        /** @var Employee $user */
        $user = $this->getUser();
//        dd(array_map(function ($x) {
//            return $x->getEmployees();
//        },$repository->findAll()));

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
}
