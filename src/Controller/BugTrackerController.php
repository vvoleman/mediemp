<?php

namespace App\Controller;

use App\Entity\Bug;
use App\Entity\EmployerLine;
use App\Form\BugReportType;
use App\Security\VerifyCsrfTrait;
use App\Service\Entity\EmployerLineService;
use App\Service\Entity\ImageService;
use App\Service\Util\PreviousUrlService;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Translation\TranslatableMessage;

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
     * @Route("/bug/report", name="app_bug_report_get")
     */
    public function index(Request $request,EntityManagerInterface $manager, ImageService $imageService): Response {
        //dd("ff");
        $bug = new Bug();
        if(!$this->previousUrlService->isSet()){
            $this->previousUrlService->set($request);
        }
        $form = $this->createForm(BugReportType::class, $bug,[
            'previous_url'=>$this->previousUrlService->previous($request)
        ]);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var Bug $bug */
            $bug = $form->getData();
            //TODO: Přesměrování

            if ($form['use_url']->getData()) {
                $bug->setUrl($this->previousUrlService->get(""));
            }

            //image upload
            $images = $imageService->saveMany($form['screenshots']->getData());
            if (sizeof($images) > 0) {
                $bug->addScreenshots($images);
            }

            $manager->persist($bug);
            $manager->flush();
            $this->addFlash("success", new TranslatableMessage("bugtracker.post.success"));
            return new RedirectResponse(($bug->getUrl()) ?: $this->generateUrl('app_home'));

        }

        return $this->renderForm("bug_tracker/index.html.twig",
            [
                "form" => $form,
                "previousUrl" => $this->previousUrlService->get("", false)
            ]
        );
    }

//    /**
//     * @Route("/bug/report",name="app_bug_report_post",methods={"POST"})
//     * @param Request $request
//     * @param BugTrackerService $trackerService
//     * @return Response
//     */
//    public function post(Request $request, BugTrackerService $trackerService): Response {
//        if(!$this->verify("post-bug",$request->request->get("_csrf_token"))){
//            return new RedirectResponse($this->previousUrlService->get($this->generateUrl("app_home"),false));
//        }
//        $result = $trackerService->postReport($request);
//
//        $status = $result ? "success" : "error";
//        $this->addFlash($status, new TranslatableMessage(sprintf("bugtracker.post.%s", $status)));
//
//        $url = $this->previousUrlService->get();
//        if (!$url) {
//            $url = $this->generateUrl("app_home");
//        }
//
//        return new RedirectResponse($url);
//    }

}
