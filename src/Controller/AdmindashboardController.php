<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdmindashboardController extends AbstractController
{
    #[Route('/admindashboard', name: 'app_admindashboard')]
    public function index(): Response
    {
        return $this->render('admindashboard/dashboardAdmin.html.twig', [
            'controller_name' => 'AdmindashboardController',
        ]);
    }
}
