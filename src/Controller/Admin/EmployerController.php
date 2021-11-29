<?php

namespace App\Controller\Admin;

use App\Form\NewEmployerType;
use App\Repository\EmployerRepository;
use Pagerfanta\Doctrine\ORM\QueryAdapter;
use Pagerfanta\Pagerfanta;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route("/admin/employers",name:"app_admin_employers")]
class EmployerController extends AbstractController {

    #[Route('',name:'')]
    public function index(Request $request, EmployerRepository $repository): Response {
        $qb = $repository->createAllEmployerQueryBuilder();
        $pagerfanta = new Pagerfanta(new QueryAdapter($qb));
        $pagerfanta->setMaxPerPage(10);
        $pagerfanta->setCurrentPage($request->query->get('page', 1));

        return $this->render('admin/employer/index.html.twig', [
            'pager' => $pagerfanta
        ]);
    }

    #[Route('/add/', name: '_add')]
    public function add(Request $request): Response {
        $form = $this->createForm(NewEmployerType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $data = $form->getData();
            dd($data);
        }

        return $this->renderForm('admin/employer/add.html.twig', [
            'form' => $form,
        ]);
    }

}