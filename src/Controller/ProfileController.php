<?php

namespace App\Controller;

use App\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @IsGranted("IS_AUTHENTICATED_REMEMBERED")
 */
class ProfileController extends AbstractController
{
    /**
     * @Route("/profile", name="app_profile_get")
     */
    public function index(): Response {
        /** @var User $user */
        $user = $this->getUser();
        $user = $user->getUser();
        return $this->render('profile/index.html.twig', [
            'user' => $user,        ]);
    }
}
