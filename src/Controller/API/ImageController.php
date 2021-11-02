<?php

namespace App\Controller\API;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/image",name="api_image")
 */
class ImageController extends AbstractController {

    /**
     * @Route("/post",name="post",methods={"POST"})
     */
    public function post(Request $request) {

    }

}