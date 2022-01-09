<?php

namespace App\Controller;

use App\Entity\User;
use App\Service\Entity\EventService;
use JetBrains\PhpStorm\ArrayShape;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CalendarController extends AbstractController
{
    /**
     * @Route("/calendar/{offset}", name="app_calendar_get", requirements={"page"="\d+"})
     */
    public function index(EventService $service, int $offset = 0): Response{
        $user = $this->getUser();
        $events = $service->get($user->getUser());
        $dates = $this->prepareDays($offset);
        return $this->render('calendar/index.html.twig', [
            "starts_at"=>$dates["starts_at"],
            "days"=>$dates["days"],
            "date"=>$dates["date"],
            "monday"=>$dates["monday"],
            "offset"=>$offset,
            "events"=>$events
        ]);
    }

    /**
     * Calculates required dates
     * @param int $offset
     * @return array
     * @throws \Exception
     */
    #[ArrayShape(["starts_at" => "int", "days" => "int", "date" => "\DateTime", "offset" => "int", "monday" => "\DateTime"])]
    private function prepareDays(int $offset): array{
        $date = new \DateTime(sprintf("%d days",$offset*7));
        $firstDate = new \DateTime($date->format("Y-m-01"));
        $starts = intval($firstDate->format("N"));
        $temp = $offset;

        if($temp<0){
            $temp--;

        }else if($temp==0){
            $temp = -1;
        }

        $monday = new \DateTime(sprintf("%d Monday",$temp));

        $days = cal_days_in_month(CAL_GREGORIAN,intval($date->format('m')),intval($date->format('Y')));

        return [
            "starts_at"=>$starts,
            "days"=>$days,
            "date"=>$date,
            "offset"=>$offset,
            "monday"=>$monday
        ];
    }

}