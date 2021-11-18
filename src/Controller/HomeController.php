<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\EmployeeRepository;
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
     * @throws \Exception
     */
    public function index(EmployeeRepository $repository,DataAssetService $service): Response {
        /** @var User $user */
        $user = $this->getUser();

        switch ($user->getType()){
            case "employee":
                $template = "home/index_employee.html.twig";
                $data = [];
                break;
            case "admin":
                $template = "home/index_admin.html.twig";
                $data = [];
                break;
            default:
                throw new \Exception("Unknown type of user",403);
        }
        return $this->render($template,$data);
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
