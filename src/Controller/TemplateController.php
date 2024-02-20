<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TemplateController extends AbstractController
{
    #[Route('/riskguard', name: 'riskguard_app')]
    public function index(): Response
    {
        return $this->render('riskguardTemplate/riskguard.html.twig', [
            'controller_name' => 'TemplateController',
        ]);
    }

   
}
