<?php

namespace App\Controller\Admin;

use App\Repository\EmployerRepository;
use Pagerfanta\Doctrine\ORM\QueryAdapter;
use Pagerfanta\Pagerfanta;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EmployerController extends AbstractController {

    /**
     * @Route("/admin/employers",name="app_admin_employers")
     * @return Response
     */
    public function index(Request $request, EmployerRepository $repository): Response {
        $qb = $repository->createAllEmployerQueryBuilder();
        $pagerfanta = new Pagerfanta(new QueryAdapter($qb));
        $pagerfanta->setMaxPerPage(10);
        $pagerfanta->setCurrentPage($request->query->get('page', 1));

        return $this->render('admin/employer/index.html.twig', [
            'pager' => $pagerfanta
        ]);
    }

    /**
     * @Route("/admin/employers/add",name="app_admin_employers_add",methods={"GET"})
     */
    public function add(){

    }

    /**
     * @Route("/admin/employers/add",name="app_admin_employers_add_post",methods={"POST"})
     */
    public function postAdd(){

    }

}