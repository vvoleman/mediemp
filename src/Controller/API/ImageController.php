<?php

namespace App\Controller\API;

use App\Repository\ImageRepository;
use App\Service\ImageService;
use App\Service\RandomService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/image",name="api_image")
 */
class ImageController extends AbstractController {

    /**
     * @Route("/post",name="_post",methods={"POST"})
     */
    public function post(Request $request, ImageService $imageService) {
        $images = $imageService->saveMany($request->files->get("files"));
        dd($images);
    }

    /**
     * @Route("/{uuid}",name="_get",methods={"GET"})
     */
    public function getImage(string $uuid, ImageRepository $repository, ImageService $imageService): Response {

        return new Response($file, 404, $headers);
    }

}