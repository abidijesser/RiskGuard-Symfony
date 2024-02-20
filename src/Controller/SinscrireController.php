<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SinscrireController extends AbstractController
{
    #[Route('/sinscrire', name: 'app_sinscrire')]
    public function index(): Response
    {
        return $this->render('sinscrire/index.html.twig', [
            'controller_name' => 'SinscrireController',
        ]);
    }
}
