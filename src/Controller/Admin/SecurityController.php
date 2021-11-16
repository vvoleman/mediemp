<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SecurityController extends AbstractController
{
    /**
     * @Route("/authentic/security", name="admin_security")
     */
    public function index(): Response
    {
        return $this->render('login_admin.html.twig', [
            'controller_name' => 'SecurityController',
        ]);
    }
}
