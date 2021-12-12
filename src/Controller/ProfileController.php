<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\EditEmployeeType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @IsGranted("IS_AUTHENTICATED_REMEMBERED")
 */
#[Route("/profile",name:"app_profile")]
class ProfileController extends AbstractController {

    #[Route("/",name:"_get")]
    public function index(): Response {
        /** @var User $user */
        $user = $this->getUser();
        $user = $user->getUser();
        return $this->render('profile/index.html.twig', [
            'user' => $user,
        ]);
    }

    #[Route("/edit",name:"_edit")]
    public function edit(Request $request) {
        $user = $this->getUser();
        $user = $user->getUser();

        $form = $this->createForm(EditEmployeeType::class,$user);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $data = $form->getData();
            dd($data);
        }

        return $this->renderForm("profile/edit.html.twig",[
            "form"=>$form
        ]);
    }

}
