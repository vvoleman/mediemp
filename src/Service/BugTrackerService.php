<?php

namespace App\Service;

use App\Entity\Bug;
use App\Event\BugTracker\BugReportCreatedEvent;
use App\Repository\BugCategoryRepository;
use App\Repository\BugRepository;
use App\Repository\EmployeeRepository;
use App\Security\LoggerAwareTrait;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\ORMException;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class BugTrackerService {

    use LoggerAwareTrait;

    private ValidatorInterface $validator;
    private EmployeeRepository $employeeRepository;
    private BugCategoryRepository $categoryRepository;
    private EntityManagerInterface $manager;
    private EventDispatcherInterface $dispatcher;
    private BugRepository $bugRepository;
    private PreviousUrlService $urlService;
    private ImageService $imageService;

    public function __construct(ValidatorInterface       $validator,
                                EmployeeRepository       $employeeRepository,
                                BugCategoryRepository    $categoryRepository,
                                BugRepository            $bugRepository,
                                EntityManagerInterface   $manager,
                                EventDispatcherInterface $dispatcher,
                                PreviousUrlService       $urlService,
                                ImageService             $imageService
    ) {
        $this->validator = $validator;
        $this->employeeRepository = $employeeRepository;
        $this->categoryRepository = $categoryRepository;
        $this->manager = $manager;
        $this->dispatcher = $dispatcher;
        $this->bugRepository = $bugRepository;
        $this->urlService = $urlService;
        $this->imageService = $imageService;
    }

    /**
     * Creates bug from request, persists it and dispatches event `bugreport.created`
     * @param Request $request
     * @return bool
     */
    public
    function postReport(Request $request): bool {
        // Assemble bug
        $bug = $this->assembleBug($request);

        // Validates bug, if failed, returns errors
        $errors = $this->validator->validate($bug);
        if ($errors->count() > 0) {
            $this->getLogger()->warning("Bug validation failed", [
                "errors" => $errors,
                "bug" => $bug
            ]);
            return false;
        }

        // Persists into DB
        try {
            $this->manager->persist($bug);
            $this->manager->flush();
        } catch (\Exception $e) {
            $this->getLogger()->warning("Unable to persist bug", [
                "exception" => $e,
                "bug" => $bug
            ]);
            return false;
        }

        // Dispatch event
        $this->dispatcher->dispatch(new BugReportCreatedEvent($bug), BugReportCreatedEvent::NAME);
        return true;
    }

    private
    function assembleBug(Request $request): Bug {
        $data = $request->request->all();
        $bug = new Bug();
        $bug->setDescription($request->request->get("description", ""));
        $bug->setCreatedAt();

        $images = $this->imageService->saveMany($request->files->get("images"));
        if (sizeof($images) > 0) {
            $bug->addScreenshots($images);
        }


        if ($request->request->has("created_by")) {
            $employee = $this->employeeRepository->find($request->request->get("created_by"));
            if (!!$employee) {
                $bug->setCreatedBy($employee);
            }
        }

        $category = $this->categoryRepository->find($request->request->get("category"));
        if (!!$category) {
            $bug->setCategory($category);
        }

        if ($this->urlService->isSet()) {
            $bug->setUrl($this->urlService->get("", true));
        }

        return $bug;
    }

}