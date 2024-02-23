<?php

namespace App\Controller;

use App\Entity\Constatvie;
use App\Form\ConstatvieType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\ConstatvieRepository;

class ConstatVIeController extends AbstractController


{
 
    #[Route('/constat/v/ie', name: 'app_constat_v_ie')]
    public function index(): Response
    {
        return $this->render('constat_v_ie/index.html.twig', [
            'controller_name' => 'ConstatVIeController',
        ]);
    }

    #[Route('/constatvief', name: 'app_constat_vie')]
    public function indexss(Request $request): Response
    {
        $form = $this->createForm(ConstatvieType::class);
    
        return $this->render('constat_v_ie/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/constatvie/add', name: 'app_constatvie_add')]
    public function addConstatVie(Request $request, ManagerRegistry $doctrine): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $ConstatVie = new Constatvie();
        $form = $this->createForm(ConstatvieType::class, $ConstatVie);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($ConstatVie);
            $entityManager->flush();
    
            // Get the ID of the newly added ConstatVie
            $id = $ConstatVie->getId();
    
            // Redirect to the show page with the new ConstatVie
            return $this->redirectToRoute('app_constat_show', ['id' => $id]); 
        }
    
        return $this->render('landingpage/choose.html.twig', [ 
            'form' => $form->createView(),
        ]);
    }
    
    



    

    #[Route('/update-constat-vie/{id}', name: 'constat_vie_update')]
    public function updateConstatVie(Request $request, ManagerRegistry $doctrine, $id): Response
    {
        $entityManager = $doctrine->getManager();
        $constatVie = $entityManager->getRepository(Constatvie::class)->find($id);
    
        if (!$constatVie) {
            throw $this->createNotFoundException('Constat Vie not found');
        }
    
        // Retrieve form data from the request
        $nom = $request->request->get('nom');
        $prenom = $request->request->get('prenom');
        $cin = $request->request->get('cin');
        $dateDeDeces = new \DateTime($request->request->get('dateDeDeces'));
        $causeDeDeces = $request->request->get('causeDeDeces');
        $identifiantDeLinformant = $request->request->get('identifiantDeLinformant');
    
        // Update Constat Vie entity with form data
        $constatVie->setNom($nom);
        $constatVie->setPrenom($prenom);
        $constatVie->setCIN($cin);
        $constatVie->setDateDeDeces($dateDeDeces);
        $constatVie->setCauseDeDeces($causeDeDeces);
        $constatVie->setIdentifiantDeLinformant($identifiantDeLinformant);
    
        // Persist the changes
        $entityManager->flush();
    
        // Redirect to the constat vie show page
        return $this->redirectToRoute('app_constat_show', ['id' => $id]);
    }

    #[Route('/delete/{id}', name: 'constatvie_delete')]
    public function delete(ConstatvieRepository $repository, ManagerRegistry $doctrine, $id): Response
    {
        $entityManager = $doctrine->getManager();
        $constatvie= $entityManager->getRepository(ConstatVie::class)->find($id);
        if (!$constatvie) {
            throw $this->createNotFoundException(
                'No constat vie found for client '.$id
            );
        }
        $entityManager->remove($constatvie);
        $entityManager->flush();


        return $this->redirectToRoute('app_landingpage');

   
    }


}








    