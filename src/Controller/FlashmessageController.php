<?php

namespace App\Controller;

use MercurySeries\FlashyBundle\FlashyNotifier;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FlashmessageController extends AbstractController
{
    #[Route('/flashmessage', name: 'app_flashmessage')]
    public function index(FlashyNotifier $flashy): Response
    {
        $flashy->success('Admin ajouté avec succès');

        return $this->render('flashmessage/index.html.twig', [
            'controller_name' => 'FlashmessageController',
        ]);
    }
}
