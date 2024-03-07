<?php

namespace App\Controller;

use App\Entity\ConstatVehicule;
use App\Form\ConstatVehiculeType;
use Knp\Component\Pager\PaginatorInterface;
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
    #[Route('/constatVehicule/back', name: 'app_constatVehicule_indexbackkkk', methods: ['GET'])]
    public function indexback(Request $request, ConstatVehiculeRepository $constatVehiculeRepository, PaginatorInterface $paginator): Response
    {
        $searchTerm = $request->query->get('search');
        $query = $constatVehiculeRepository->searchByTypeOrMarque($searchTerm);

        // Paginate the query results
        $constatVehicule = $paginator->paginate(
            $query, // Query to paginate
            $request->query->getInt('page', 1), // Page number
           4
        // Items per page
        );

        return $this->render('constat_vehicule/indexback.html.twig', [
            'constatVehicule' => $constatVehicule,
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


    $prenom = $request->request->get('prenom');
    $cin = $request->request->get('cin');
    $typeVehicule = $request->request->get('typeVehicule');
    $marque = $request->request->get('marque');
    $matricule = $request->request->get('matricule');
    $lieu = $request->request->get('lieu');
    $date = new \DateTime($request->request->get('date'));
    $description = $request->request->get('description');


    $constatVehicule->setPrenom($prenom);
    $constatVehicule->setCIN($cin);
    $constatVehicule->setTypeVehicule($typeVehicule);
    $constatVehicule->setMarque($marque);
    $constatVehicule->setMatricule($matricule);
    $constatVehicule->setLieu($lieu);
    $constatVehicule->setDate($date);
    $constatVehicule->setDescription($description);

    $entityManager->flush();
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

    #[Route('/stats', name: 'stats')]
    public function indexstat(ConstatVehiculeRepository $repository): Response
    {
        $stats = $repository->getStatsByTypeVehicule();

        $labels = [];
        $data = [];

        foreach ($stats as $stat) {
            $labels[] = $stat['TypeVehicule'];
            $data[] = $stat['total'];
        }

        $chartOptions = [
            'type' => 'bar',
            'data' => [
                'labels' => $labels,
                'datasets' => [
                    [
                        'label' => 'Nombre de constats par type de véhicule',
                        'data' => $data,
                        'backgroundColor' => 'rgba(75, 192, 192, 0.2)',
                        'borderColor' => 'rgba(75, 192, 192, 1)',
                        'borderWidth' => 1,
                    ],
                ],
            ],
        ];

        return $this->render('constat_vehicule/stats.html.twig', [
            'chartOptions' => $chartOptions,
        ]);
    }


    }

