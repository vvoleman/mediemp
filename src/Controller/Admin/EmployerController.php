<?php

namespace App\Controller\Admin;

use App\Entity\Employer;
use App\Entity\EmployerLine;
use App\Event\Employer\EmployerCreatedEvent;
use App\Form\NewEmployerType;
use App\Repository\EmployerLineRepository;
use App\Repository\EmployerRepository;
use App\Service\Entity\EmployerLineService;
use App\Service\Entity\EmployerService;
use Pagerfanta\Doctrine\ORM\QueryAdapter;
use Pagerfanta\Pagerfanta;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
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
    public function add(Request $request,EmployerService $service,EventDispatcherInterface $dispatcher): Response {
        $form = $this->createForm(NewEmployerType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $data = $form->getData();
            /** @var EmployerLine $line */
            $line = $data["employer_id"];
            $data = EmployerLineService::formatArrayToEmployer($line,$data["email"]);
            $employer = $service->postEmployer($data);

            if($employer){
                $dispatcher->dispatch(new EmployerCreatedEvent($employer));
                $this->addFlash("success","Zaměstnavatel přidán, na email Vám přijde potvrzovací odkaz");
                return $this->redirectToRoute("app_home");
            }else{
                $this->addFlash("error","Nelze vytvořit nového zaměstnavatele!");
            }
        }

        return $this->renderForm('admin/employer/add.html.twig', [
            'form' => $form,
        ]);
    }

}