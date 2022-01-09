<?php

namespace App\Controller\Admin;

use App\Service\Entity\EmployerLineService;
use App\Service\Util\TimeTrackerTrait;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class EmployerLineController extends AbstractController {

    use TimeTrackerTrait;

    #[Route('/admin/employer_line/update')]
    public function index(EmployerLineService $service) {
        $this->start();
        $service->update();
        dd(sprintf("Aktualizováno za: %ds",$this->stop()));
    }

}