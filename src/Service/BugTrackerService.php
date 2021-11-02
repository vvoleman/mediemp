<?php

namespace App\Service;

use App\Entity\Bug;
use App\Event\BugTracker\BugReportCreatedEvent;
use App\Repository\BugCategoryRepository;
use App\Repository\BugRepository;
use App\Repository\EmployeeRepository;
use App\Security\LoggerAwareTrait;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\ORMException;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class BugTrackerService {

    use LoggerAwareTrait;

    private ValidatorInterface $validator;
    private EmployeeRepository $employeeRepository;
    private BugCategoryRepository $categoryRepository;
    private EntityManager $manager;
    private EventDispatcherInterface $dispatcher;
    private BugRepository $bugRepository;

    public function __construct(ValidatorInterface       $validator,
                                EmployeeRepository       $employeeRepository,
                                BugCategoryRepository    $categoryRepository,
                                BugRepository            $bugRepository,
                                EntityManager            $manager,
                                EventDispatcherInterface $dispatcher
    ) {
        $this->validator = $validator;
        $this->employeeRepository = $employeeRepository;
        $this->categoryRepository = $categoryRepository;
        $this->manager = $manager;
        $this->dispatcher = $dispatcher;
        $this->bugRepository = $bugRepository;
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

        if ($request->request->has("created_by")) {
            $employee = $this->employeeRepository->find($request->request->get("created_by"));
            if (!!$employee) {
                $bug->setCreatedBy($employee);
            }
        }

        $bug->setCategory($this->categoryRepository->find($request->request->get("category")));
        $bug->setUrl($request->request->get("bug_url"));

        return $bug;
    }

}