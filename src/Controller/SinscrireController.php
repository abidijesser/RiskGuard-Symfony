<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Client;
use App\Form\Client1Type;
use App\Repository\ClientRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;


class SinscrireController extends AbstractController
{
    #[Route('/sinscrire/ajouter', name: 'app_sinscrire_ajouter')]
    public function new(ManagerRegistry $doctrine, Request $request): Response
    {
        $em= $doctrine->getManager();
        $client = new Client();

        // Récupérer les données du formulaire à partir de la requête
        $nom = $request->request->get('nom');
        $prenom = $request->request->get('prenom');
        $cin = $request->request->get('cin');        
        $email = $request->request->get('email');
        $telephone = $request->request->get('telephone');       
        $date_de_naissance = $request->request->get('date_de_naissance');
        $mot_de_passe = $request->request->get('password');       
        $adresse_domicile = $request->request->get('adresse_domicile');
        
        // Définir les valeurs récupérées sur l'objet Client
        $client->setNom($nom);
        $client->setPrenom($prenom);
        $client->setCin($cin);
        $client->setEmail($email);
        $client->setTelephone($telephone);
        // Convertir la date de naissance en objet DateTime si nécessaire
        $client->setDateDeNaissance(new \DateTime($date_de_naissance));
        $client->setMotDePasse($mot_de_passe);
        $client->setAdresseDomicile($adresse_domicile);

        // Enregistrer l'objet Client en base de données
        $em->persist($client);
        $em->flush();

        // Rediriger vers une autre page après l'inscription
        return $this->redirectToRoute('client_allshow');
    }

    #[Route('/sinscrire', name: 'app_sinscrire')]
    public function index(): Response
    {
        return $this->render('sinscrire/index.html.twig');
    }
}

