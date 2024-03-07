<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Sinistre;
use App\Entity\Constatvie;
use App\Entity\ConstatVehicule;

class LandingpageController extends AbstractController
{
    #[Route('/landingpage', name: 'app_landingpage')]
    public function index(): Response
    {
        return $this->render('landingpage/index.html.twig', [
            'controller_name' => 'LandingpageController',
        ]);
    }


    #[Route('/landingpage/choose', name: 'app_landingpagee')]
    public function choose(): Response
    {
        return $this->render('landingpage/choose.html.twig', [
            'controller_name' => 'LandingpageController',
        ]);
        
    }


    #[Route('/landingpage/show', name: 'app_landingpagesh')]
    public function shoow(): Response
    {
        return $this->render('landingpage/show.html.twig', [
            'controller_name' => 'LandingpageController',
        ]);
        
    }


    






 
    

    #[Route('/{id}', name: 'app_constat_show', methods: ['GET'])]
public function show(int $id): Response
    
{


    $entityManager = $this->getDoctrine()->getManager();
    
    // Fetch the Sinistre entity by ID
    $sinistre = $entityManager->getRepository(Sinistre::class)->find($id);

    // Check if the Sinistre entity exists
    if (!$sinistre) {
        throw $this->createNotFoundException('Sinistre not found');
    }

    // Fetch the corresponding entity based on the Sinistre type
    if ($sinistre instanceof Constatvie) {
        $constat_vie = $sinistre;
        $constat_vehicule = null; // Set the other entity to null
    } elseif ($sinistre instanceof ConstatVehicule) {
        $constat_vie = null; // Set the other entity to null
        $constat_vehicule = $sinistre;
    } else {
        throw new \LogicException('Unknown sinistre type');
    }

    return $this->render('landingpage/show.html.twig', [
        'constat_vie' => $constat_vie,
        'constat_vehicule' => $constat_vehicule,
    ]);
}

    }
    


