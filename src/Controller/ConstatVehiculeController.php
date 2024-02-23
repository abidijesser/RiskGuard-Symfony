<?php

namespace App\Controller;

use App\Entity\ConstatVehicule;
use App\Form\ConstatVehiculeType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\ConstatVehiculeRepository;
use Doctrine\Persistence\ManagerRegistry;


class ConstatVehiculeController extends AbstractController
{
    #[Route('/constat/vehiculee', name: 'app_constat_vehiculee')]
    public function index(): Response
    {
        return $this->render('constat_vehicule/vehicule.html.twig', [
            'controller_name' => 'ConstatVehiculeController',
        ]);
    }
    #[Route('/constat/vehicule', name: 'app_constat_vehicule')]
    public function vvv(Request $request): Response
    {
        $form = $this->createForm(ConstatVehiculeType::class);
    
        return $this->render('constat_vehicule/vehicule.html.twig', [
            'form' => $form->createView(),

            
        ]);

    }



    #[Route('/vehicule/new', name: 'app_constat_vehicule_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $ConstatVehicule = new ConstatVehicule();
        $form = $this->createForm(ConstatVehiculeType::class, $ConstatVehicule);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($ConstatVehicule);
            $entityManager->flush();
    
            // Get the ID of the newly added ConstatVehicule
            $id = $ConstatVehicule->getId();
    
            // Redirect to the show page with the new ConstatVehicule
            return $this->redirectToRoute('app_constat_show', ['id' => $id]); 
        }
    
        return $this->render('landingpage/choose.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    
    



    


    #[Route('/update-constat-vehicule/{id}', name: 'constat_vehicule_update')]
public function updateConstatVehicule(Request $request, ManagerRegistry $doctrine, $id): Response
{
    $entityManager = $doctrine->getManager();
    $constatVehicule = $entityManager->getRepository(ConstatVehicule::class)->find($id);

    if (!$constatVehicule) {
        throw $this->createNotFoundException('Constat Vehicule not found');
    }

    // Retrieve form data from the request
    $prenom = $request->request->get('prenom');
    $cin = $request->request->get('cin');
    $typeVehicule = $request->request->get('typeVehicule');
    $marque = $request->request->get('marque');
    $matricule = $request->request->get('matricule');
    $lieu = $request->request->get('lieu');
    $date = new \DateTime($request->request->get('date'));
    $description = $request->request->get('description');

    // Update Constat Vehicule entity with form data
    $constatVehicule->setPrenom($prenom);
    $constatVehicule->setCIN($cin);
    $constatVehicule->setTypeVehicule($typeVehicule);
    $constatVehicule->setMarque($marque);
    $constatVehicule->setMatricule($matricule);
    $constatVehicule->setLieu($lieu);
    $constatVehicule->setDate($date);
    $constatVehicule->setDescription($description);

    // Persist the changes
    $entityManager->flush();

    // Redirect to the constat vehicule show page
    return $this->redirectToRoute('app_constat_show', ['id' => $id]);
}



#[Route('/deleteve/{id}', name: 'constatvehicule_delete')]
public function delete(ConstatvehiculeRepository $repository, ManagerRegistry $doctrine, $id): Response
{
    $entityManager = $doctrine->getManager();
    $constatvehicule= $entityManager->getRepository(ConstatVehicule::class)->find($id);
    if (!$constatvehicule) {
        throw $this->createNotFoundException(
            'No client found for id '.$id
        );
    }
    $entityManager->remove($constatvehicule);
    $entityManager->flush();
    return $this->redirectToRoute('app_landingpage');


}

    
        
       
    }

