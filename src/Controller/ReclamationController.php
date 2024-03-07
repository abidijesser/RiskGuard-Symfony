<?php

namespace App\Controller;
use App\Repository\ReponseRepository;
use App\Entity\Reclamation;
use App\Form\ReclamationType;
use App\Repository\ReclamationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Service\ProfanityChecker;
use Knp\Component\Pager\PaginatorInterface;




class ReclamationController extends AbstractController
{
    #[Route('/display_home', name: 'display_home')]
    public function index(): Response
    {
        return $this->render('reclamation/index.html.twig', [
            'controller_name' => 'ReclamationController',
        ]);
    }

    #[Route('/back', name: 'back')]
    public function back(): Response
    {
        return $this->render('reclamation/back.html.twig');
    }

    #[Route('/addReclamation', name: 'addReclamation')]
    public function addReclamation(Request $request, ProfanityChecker $profanityChecker): Response
    {
        $reclamation = new Reclamation();
        $form = $this->createForm(ReclamationType::class, $reclamation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $content = $reclamation->getDescription();
            if ($profanityChecker->containsProfanity($content)) {
                $this->addFlash('error', 'Votre réclamation contient des mots offensives. Veuillez reformuler votre message.');
            } else {
                // Persister la réclamation
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($reclamation);
                $entityManager->flush();

                return $this->redirectToRoute('display_home');
            }
        }

        // Réafficher le formulaire avec les éventuels messages flash
        return $this->render('reclamation/createReclamation.html.twig', [
            'f' => $form->createView(),
        ]);
    }



    #[Route('/display_reclamation', name: 'display_reclamation')]
    public function afficheReclamation(
        ReponseRepository $reponseRepository,
        PaginatorInterface $paginator,
        Request $request
    ): Response {
        // Récupérer toutes les réclamations sans pagination
        $allReclamations = $this->getDoctrine()->getManager()->getRepository(Reclamation::class)->findAll();

        // Paginer les réclamations
        $reclamations = $paginator->paginate(
            $allReclamations,
            $request->query->getInt('page', 1), // Récupérer le numéro de page depuis la requête
            4 // Nombre d'éléments par page
        );

        // Calculer les statistiques des réclamations
        $stats = $this->calculateReclamationStats($allReclamations, $reponseRepository);

        return $this->render('reclamation/afficheReclamations.html.twig', [
            'r' => $reclamations,
            'reponseRepository' => $reponseRepository,
            'stats' => $stats
        ]);
    }

    private function calculateReclamationStats(array $reclamations, ReponseRepository $reponseRepository): array
    {
        $totalReclamations = count($reclamations);
        $reclamationsRepondues = 0;
        $reclamationsNonRepondues = 0;

        foreach ($reclamations as $reclamation) {
            $reponses = $reponseRepository->findReponsesForReclamation($reclamation);
            if (!empty($reponses)) {
                $reclamationsRepondues++;
            } else {
                $reclamationsNonRepondues++;
            }
        }

        return [
            'totalReclamations' => $totalReclamations,
            'reclamationsRepondues' => $reclamationsRepondues,
            'reclamationsNonRepondues' => $reclamationsNonRepondues
        ];
    }

    #[Route('/deleteReclamation/{id}', name: 'delete_reclamation')]
    public function suppressionReclamation(Request $request, ReponseRepository $reponseRepository): Response
    {
        $em = $this->getDoctrine()->getManager();

        // Récupérer l'identifiant de la réclamation à partir des paramètres de la requête
        $idReclamation = $request->get('id');

        // Charger l'entité Reclamation à partir de la base de données
        $reclamation = $em->getRepository(Reclamation::class)->find($idReclamation);

        // Vérifier si la réclamation existe
        if (!$reclamation) {
            throw $this->createNotFoundException('Réclamation non trouvée');
        }
        // Vérifier si la réclamation a une réponse
        $reponse = $reponseRepository->findOneBy(['reclamation' => $reclamation]);

        if ($reponse !== null) {
            throw new \Exception('Cette réclamation a déjà une réponse et ne peut pas être supprimée.');
        }


        // Supprimer la réclamation
        $em->remove($reclamation);
        $em->flush();

        return $this->redirectToRoute('display_reclamation');
    }
    #[Route('/edit_reclamation/{id}', name: 'edit_reclamation')]
    public function modifReclamation(Request $request, $id): Response
    {
        $reclamation = $this->getDoctrine()->getManager()->getRepository(Reclamation::class)->find($id);

        $form = $this->createForm(ReclamationType::class, $reclamation);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();

            return $this->redirectToRoute('display_reclamation');
        }

        return $this->render('reclamation/updateReclamation.html.twig', ['f' => $form->createView()]);
    }
}
