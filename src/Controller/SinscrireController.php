<?php

namespace App\Controller;

use MercurySeries\FlashyBundle\FlashyNotifier;
use MercurySeries\FlashyBundle\MercurySeriesFlashyBundle;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
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
    public function new(ManagerRegistry $doctrine, Request $request, SessionInterface $session, FlashyNotifier $flashy ): Response
    {
        $em= $doctrine->getManager();
        $email = $request->request->get('email');
        $existingClient = $em->getRepository(Client::class)->findOneBy(['email' => $email]);

        if ($existingClient) {
            $flashy->error('Cet email existe déjà.');
            return $this->redirectToRoute('app_sinscrire');
        }

        $client = new Client();
        $nom = $request->request->get('nom');
        $prenom = $request->request->get('prenom');
        $cin = $request->request->get('cin');        
        $email = $request->request->get('email');
        $telephone = $request->request->get('telephone');       
        $date_de_naissance = $request->request->get('date_de_naissance');
        $mot_de_passe = $request->request->get('password');       
        $adresse_domicile = $request->request->get('adresse_domicile');

        $client->setNom($nom);
        $client->setPrenom($prenom);
        $client->setCin($cin);
        $client->setEmail($email);
        $client->setTelephone($telephone);
        $client->setDateDeNaissance(new \DateTime($date_de_naissance));
        $client->setMotDePasse($mot_de_passe);
        $client->setAdresseDomicile($adresse_domicile);

        $session->set('nom',$nom);
        $session->set('email',$email);
        $session->set('telephone',$telephone);

        $em->persist($client);
        $em->flush();
        $flashy->success('Inscription faite avec succés. ');

        return $this->redirectToRoute('display_home');
    }

    #[Route('/sinscrire', name: 'app_sinscrire')]
    public function index(): Response
    {
        return $this->render('sinscrire/index.html.twig');
    }
}

