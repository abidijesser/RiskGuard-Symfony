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
    public function addReclamation(Request $request): Response
    {
        $reclamation = new Reclamation();

        $form = $this->createForm(ReclamationType::class,$reclamation);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($reclamation);//Add
            $em->flush();
            return $this->redirectToRoute('display_home');
        }
        return $this->render('reclamation/createReclamation.html.twig',['f'=>$form->createView()]);

    }


    #[Route('/display_reclamation', name: 'display_reclamation')]
    public function afficheReclamation(ReponseRepository $reponseRepository): Response
    {
        $reclamations = $this->getDoctrine()->getManager()->getRepository(Reclamation::class)->findAll();
        return $this->render('reclamation/afficheReclamations.html.twig', [
            'r' => $reclamations,
            'reponseRepository' => $reponseRepository
        ]);
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
