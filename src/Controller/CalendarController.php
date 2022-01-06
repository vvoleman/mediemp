<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CalendarController extends AbstractController
{
    /**
     * @Route("/calendar/{offset}", name="app_calendar_get", requirements={"page"="\d+"})
     */
    public function index(int $offset = 0): Response{
        $date = new \DateTime(sprintf("%ddays",$offset*7));
        $firstDate = new \DateTime($date->format("Y-m-01"));
        $starts = intval($firstDate->format("N"));
        $temp = $offset;
        if($temp<0){
            $temp--;

        }else if($temp==0){
            $temp = -1;
        }
        $monday = new \DateTime(sprintf("%d Monday",$temp));
        $sunday = new \DateTime("sunday this week");
      //  dd($monday,$sunday);

        $days = cal_days_in_month(CAL_GREGORIAN,intval($date->format('m')),intval($date->format('Y')));
        return $this->render('calendar/index.html.twig', [
            "starts_at"=>$starts,
            "days"=>$days,
            "date"=>$date,
            "offset"=>$offset,
            "monday"=>$monday
            //"sunday"=> $sunday ->format("d. m.")
        ]);
    }
}
