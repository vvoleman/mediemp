<?php

namespace App\Controller\API;

use App\Repository\EmployerLineRepository;
use phpDocumentor\Reflection\DocBlock\Serializer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route("/api/employer", name: 'api_employer')]
class EmployerController extends AbstractController {

    private EmployerLineRepository $lineRepository;

    public function __construct(EmployerLineRepository $lineRepository) {
        $this->lineRepository = $lineRepository;
    }

    #[Route("/search", name: '_search')]
    public function search(Request $request,SerializerInterface $serializer): JsonResponse {
        $query = $request->query->get("query");
        $page = $request->query->get("page",0);

        if($query == null){
            return $this->json([
                "status"=>Response::HTTP_BAD_REQUEST,
                "message"=>"Query need to be passed"
            ]);
        }
        if(!is_numeric($page)){
            return $this->json([
                "status"=>Response::HTTP_BAD_REQUEST,
                "message"=>"Page must be a number"
            ]);
        }

        $qb = $this->lineRepository->getSearchQuery($query,$page);
        $results = $this->lineRepository->search($query, $page);
        $sizeOfQuery = $this->lineRepository->getSizeOfQuery($qb);

        return $this->json([
            "status" => 200,
            "data" => $results,
            "has_next"=>$this->lineRepository->hasNext($page,$qb),
            "total_count"=>$sizeOfQuery,
            "limit"=>$this->lineRepository::PAGE_SIZE],
            200,[],['groups'=>'safe']
        );
    }

}