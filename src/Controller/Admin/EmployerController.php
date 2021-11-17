<?php

namespace App\Controller\Admin;

use App\Repository\EmployerRepository;
use Pagerfanta\Doctrine\ORM\QueryAdapter;
use Pagerfanta\Pagerfanta;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EmployerController extends AbstractController {

    /**
     * @Route("/admin/employers",name="app_admin_employers_get")
     * @return Response
     */
    public function index(EmployerRepository $repository): Response {
        $qb = $repository->createAllEmployerQueryBuilder();
        $pagerfanta = new Pagerfanta(new QueryAdapter($qb));
        $pagerfanta->setMaxPerPage(5);

        return $this->render('admin/employer/index.html.twig',[
            'pager'=>$pagerfanta
        ]);
    }

}