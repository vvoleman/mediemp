<?php

namespace App\Controller;

use App\Repository\BugCategoryRepository;
use App\Security\VerifyCsrfTrait;
use App\Service\BugTrackerService;
use App\Service\PreviousUrlService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Translation\TranslatableMessage;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * @IsGranted("IS_AUTHENTICATED_REMEMBERED")
 */
class BugTrackerController extends AbstractController {
    use VerifyCsrfTrait;

    private PreviousUrlService $previousUrlService;

    public function __construct(PreviousUrlService $previousUrlService) {
        $this->previousUrlService = $previousUrlService;
    }

    /**
     * @Route("/bug/report", name="app_bug_report_get",methods={"GET"})
     */
    public function index(Request $request, BugCategoryRepository $repository): Response {
        $this->previousUrlService->set($request);

        return $this->render("bug_tracker/index.html.twig",
            [
                "categories"=>$repository->findAll(),
                "previousUrl"=>$this->previousUrlService->get("",false)
            ]
        );
    }

    /**
     * @Route("/bug/report",name="app_bug_report_post",methods={"POST"})
     * @param Request $request
     * @param BugTrackerService $trackerService
     * @return Response
     */
    public function post(Request $request, BugTrackerService $trackerService): Response {
        if(!$this->verify("post-bug",$request->request->get("_csrf_token"))){
            return new RedirectResponse($this->previousUrlService->get($this->generateUrl("app_home"),false));
        }
        $result = $trackerService->postReport($request);

        $status = $result ? "success" : "error";
        $this->addFlash($status, new TranslatableMessage(sprintf("bugtracker.post.%s", $status)));

        $url = $this->previousUrlService->get();
        if (!$url) {
            $url = $this->generateUrl("app_home");
        }

        return new RedirectResponse($url);
    }

}
