<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Http\Util\TargetPathTrait;

/**
 * @Route("/auth",name="app_security")
 */
class SecurityController extends AbstractController
{
    use TargetPathTrait;

    /**
     * @Route("/",name="")
     */
    public function hub(Request $request): Response{
        $this->redirectIfLogged($this->getUser(),$request);

        return $this->render("security/index.html.twig");
    }

    /**
     * @Route("/employee", name="_employee")
     */
    public function login(AuthenticationUtils $authenticationUtils,Request $request): Response
    {
        $this->redirectIfLogged($this->getUser(),$request);

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername,
            'error'         => $error,
        ]);
    }

    /**
     * @Route("/logout",name="_logout")
     */
    public function logout() {

    }

    private function redirectIfLogged(?UserInterface $user, Request $request){
        if($this->isGranted($user,"IS_AUTHENTICATED_REMEMBERED")){
            return new RedirectResponse("app_home");
        }
    }
}
