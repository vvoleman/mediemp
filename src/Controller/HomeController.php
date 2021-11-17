<?php

namespace App\Controller;

use App\Repository\EmployerRepository;
use App\Service\Entity\DataAssetService;
use App\Service\Util\TimeTrackerTrait;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController {
    use TimeTrackerTrait;
    /**
     * @Route("/", name="app_home")
     */
    public function index(EmployerRepository $repository,DataAssetService $service): Response {
        return $this->render('home/index.html.twig');
    }

    public function renderFlashMessages() {
        return $this->render("partials/_flashmessages.html.twig", [
            "classes" => [
                "error" => "danger",
                "success" => "success",
                "info" => "info",
                "warning" => "warning"
            ]
        ]);
    }
}
