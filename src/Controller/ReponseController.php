<?php

namespace App\Controller;
use App\Entity\Reclamation;
use App\Entity\Reponse;
use App\Form\ReponseType;
use App\Repository\ReponseRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

class ReponseController extends AbstractController
{

    #[Route('/addReponse/{id_reclamation}', name: 'addReponse')]
    public function addReponse(Request $request, $id_reclamation): Response
    {
        $reponse = new Reponse();

        // Récupérer la réclamation correspondante à partir de l'identifiant
        $reclamation = $this->getDoctrine()->getRepository(Reclamation::class)->find($id_reclamation);

        // Remplir automatiquement le champ reclamation dans le formulaire avec la réclamation correspondante
        $reponse->setReclamation($reclamation);

        // Créer le formulaire pour la saisie de la réponse avec la réclamation pré-remplie
        $form = $this->createForm(ReponseType::class, $reponse);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Associer la réclamation à partir de la saisie du formulaire
            // Ici, nous supposons que le formulaire contient un champ 'reclamation' qui représente l'entité Reclamation
            $reclamation = $reponse->getReclamation();
            $reponse->setReclamation($reclamation);

            // Persister la réponse
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($reponse);
            $entityManager->flush();

            // Rediriger vers une autre page après l'ajout de la réponse
            return $this->redirectToRoute('display_reponse');
        }

        // Afficher le formulaire pour ajouter une nouvelle réponse
        return $this->render('reponse/createReponse.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/editReponse/{id}', name: 'editReponse')]
    public function editReponse(Request $request, $id): Response
    {
        // Récupérer la réponse correspondant à l'ID
        $reponse = $this->getDoctrine()->getManager()->getRepository(Reponse::class)->find($id);

        // Vérifier si la réponse existe
        if (!$reponse) {
            throw $this->createNotFoundException('La réponse avec l\'ID '.$id.' n\'existe pas.');
        }

        // Créer le formulaire de modification de réponse
        $form = $this->createForm(ReponseType::class, $reponse);

        // Gérer la soumission du formulaire
        $form->handleRequest($request);

        // Vérifier si le formulaire a été soumis et est valide
        if ($form->isSubmitted() && $form->isValid()) {
            // Enregistrer les modifications dans la base de données
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();

            // Rediriger vers la page de visualisation des réponses après la modification
            return $this->redirectToRoute('display_reponse');
        }

        // Récupérer la description de la réclamation associée à la réponse
        $reclamation = $reponse->getDescription();


        // Rendre le template avec le formulaire et la description de la réclamation
        return $this->render('reponse/editReponse.html.twig', [
            'f' => $form->createView(),
            'description' => $reclamation
        ]);
    }


    #[Route('/display_reponse', name:'display_reponse')]
    public function displayReponse(): Response
    {
        // Récupérer toutes les réponses
        $reponses = $this->getDoctrine()->getManager()->getRepository(Reponse::class)->findAll();

        // Créer un tableau pour stocker les réclamations associées à chaque réponse
        $reclamations = [];

        // Pour chaque réponse, récupérer la réclamation associée
        foreach ($reponses as $reponse) {
            $reclamations[] = $reponse->getReclamation();
        }

        return $this->render('reponse/display_reponse.html.twig', [
            'reponses' => $reponses,
            'reclamations' => $reclamations,
        ]);
    }

    #[Route('/display_front', name:'display_front')]
    public function display_front(): Response
    {
        // Récupérer toutes les réponses
        $reponses = $this->getDoctrine()->getManager()->getRepository(Reponse::class)->findAll();

        // Créer un tableau pour stocker les réclamations associées à chaque réponse
        $reclamations = [];

        // Pour chaque réponse, récupérer la réclamation associée
        foreach ($reponses as $reponse) {
            $reclamations[] = $reponse->getReclamation();
        }

        return $this->render('reclamation/ReclamationReponseFront.html.twig', [
            'reponses' => $reponses,
            'reclamations' => $reclamations,
        ]);
    }




    #[Route('/deleteReponse/{id}', name: 'delete_reponse')]
    public function deleteReponse(Request $request): Response
    {
        $em = $this->getDoctrine()->getManager();

        // Récupérer l'identifiant de la réponse à partir des paramètres de la requête
        $idReponse = $request->get('id');

        // Charger l'entité Reponse à partir de la base de données
        $reponse = $em->getRepository(Reponse::class)->find($idReponse);

        // Vérifier si la réponse existe
        if (!$reponse) {
            throw $this->createNotFoundException('Réponse non trouvée');
        }

        // Supprimer la réponse
        $em->remove($reponse);
        $em->flush();

        return $this->redirectToRoute('display_reponse');
    }
}


