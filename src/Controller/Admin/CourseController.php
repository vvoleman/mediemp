<?php

namespace App\Controller\Admin;

use App\Entity\GlobalCourse;
use App\Repository\GlobalCourseRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

//#[IsGranted("")] is admin TBA
#[Route("/admin/courses", name: "app_admin_courses")]
class CourseController extends AbstractController {

    #[Route("/", name: "", methods: ["GET"])]
    public function index(GlobalCourseRepository $repository): Response {
        $records = $repository->findAll();
        return $this->render('courses/admin/index.html.twig', [
            'courses' => $records
        ]);
    }

    #[Route("/", name: "_post", methods: ["POST"])]
    public function indexCoursesPost(GlobalCourseRepository $repository, Request $request, EntityManagerInterface $entityManager): Response {
        if ($request->request->get('action') == "delete_course") {
            $old = $repository->findOneBy(['id' => $request->request->get('id')]);
            $entityManager->remove($old);
            $entityManager->flush();
            $this->addFlash("success", "Kurz smazán");
        } else if ($request->request->get('action') == "create_course") {
            $new = new GlobalCourse();
            $new->setName($request->request->get('name'));
            $new->setKeywords($request->request->get('keywords'));
            $new->setFocus($request->request->get('focus'));
            $new->setSpecialization($request->request->get('specialization'));
            $entityManager->persist($new);
            $entityManager->flush();
            $this->addFlash("success", "Kurz vytvořen");
            return new RedirectResponse($this->generateUrl("app_admin_courses_edit", ["id", $new->getId()]));
        }
        return new RedirectResponse($this->generateUrl("app_admin_courses"));
    }

    #[Route("/{id}", name: "_edit", methods: ["GET"])]
    public function edit(GlobalCourse $course): Response {
        return $this->render('courses/admin/edit.html.twig', [
            'controller_name' => 'CoursesController',
            'course' => $course,
            'emp_course' => $course->getEmployerCourses(),
        ]);
    }

    #[Route("/{id}", name: "_edit_post", methods: ["POST"])]
    public function postEdit(GlobalCourse $c, Request $request, EntityManagerInterface $entityManager): Response {
        if ($request->request->get('action') == "edit_course") {
            $c->setName($request->request->get('name'));
            $c->setFocus($request->request->get('focus'));
            $c->setSpecialization($request->request->get('specialization'));
            $c->setKeywords($request->request->get('keywords'));
            $entityManager->persist($c);
            $entityManager->flush();
            $this->addFlash("success", "Uloženo");
        }
        return new RedirectResponse($this->generateUrl("app_admin_courses_edit", ['id' => $c->getId()]));
    }

}