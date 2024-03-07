<?php

namespace App\Controller;

use App\Entity\Constatvie;
use App\Form\ConstatvieType;
use Dompdf\Dompdf;
use Dompdf\Options;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\ConstatvieRepository;
use Twilio\Exceptions\ConfigurationException;
use Twilio\Exceptions\TwilioException;
use Twilio\Rest\Client;


class ConstatVIeController extends AbstractController


{
 
    #[Route('/constat/v/ie', name: 'app_constat_v_ie')]
    public function index(): Response
    {
        return $this->render('constat_v_ie/index.html.twig', [
            'controller_name' => 'ConstatVIeController',
        ]);
    }


    #[Route('/constatvie/back', name: 'app_constatvie_indexback')]
    public function indexbadck(ConstatvieRepository $constatvieRepository): Response
    {
        $constatvies = $constatvieRepository->findAll();

        return $this->render('constat_v_ie/indexback.html.twig', [
            'constatvies' => $constatvies,
        ]);
    }
    #[Route('/constatvie', name: 'app_constatvie_sort')]
    public function sort(ConstatvieRepository $constatvieRepository): Response
    {
        $constatvies = $constatvieRepository->findAllSortedByDateDeDeces();

        return $this->render('constat_v_ie/sort.html.twig', [
            'constatvies' => $constatvies,
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
            $this->sendTwilioMessage($ConstatVie);


            $id = $ConstatVie->getId();
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
    
        
        $nom = $request->request->get('nom');
        $prenom = $request->request->get('prenom');
        $cin = $request->request->get('cin');
        $dateDeDeces = new \DateTime($request->request->get('dateDeDeces'));
        $causeDeDeces = $request->request->get('causeDeDeces');
        $identifiantDeLinformant = $request->request->get('identifiantDeLinformant');
    
        $constatVie->setNom($nom);
        $constatVie->setPrenom($prenom);
        $constatVie->setCIN($cin);
        $constatVie->setDateDeDeces($dateDeDeces);
        $constatVie->setCauseDeDeces($causeDeDeces);
        $constatVie->setIdentifiantDeLinformant($identifiantDeLinformant);
    
       
        $entityManager->flush();
    
       
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
    #[Route('/constatvief', name: 'app_constat_vie')]
    public function indexss(Request $request): Response
    {
        $form = $this->createForm(ConstatvieType::class);

        return $this->render('constat_v_ie/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    #[Route('/constat/pdf/{id}', name: 'app_cosntat_pdf')]
    public function generatePdf(Request $request): Response
    {
        $constatvieId = $request->attributes->get('id');

        $entityManager = $this->getDoctrine()->getManager();

        $constatvie = $entityManager->getRepository(Constatvie::class)->find($constatvieId);

        if (!$constatvie) {
            throw $this->createNotFoundException('Constatvie with id ' . $constatvieId . ' not found');
        }

        $html = $this->renderView('constat_v_ie/pdf_template.html.twig', [
            'constatvie' => $constatvie,
        ]);

        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');

        $dompdf = new Dompdf($pdfOptions);
        $dompdf->loadHtml($html);

        $dompdf->setPaper('A4', 'portrait');

        $dompdf->render();

        $output = $dompdf->output();

        $response = new Response($output);
        $response->headers->set('Content-Type', 'application/pdf');

        return $response;
    }
    /**
     * Sends a Twilio message for the given Constatvie.
     *
     * @param Constatvie $constatvie The Constatvie entity
     *
     * @throws ConfigurationException
     * @throws TwilioException
     */
    private function sendTwilioMessage(Constatvie $constatvie): void
    {
        $twilioAccountSid = $this->getParameter('twilio_account_sid');
        $twilioAuthToken = $this->getParameter('twilio_auth_token');
        $twilioPhoneNumber = $this->getParameter('twilio_phone_number');

        $twilioClient = new Client($twilioAccountSid, $twilioAuthToken);

        $NOM = $constatvie->getNom();
        $PRenom = $constatvie->getPrenom();
        $decesId = $constatvie->getId();
        $decesDate = $constatvie->getDateDeDeces()->format('Y-m-d');
        $causeDeDeces = $constatvie->getCauseDeDeces();
        $informantId = $constatvie->getIdentifiantDeLinformant();


        $message = "Nouveau constat de vie créé:\n";

        $message .= "ID du constat: $decesId\n";
        $message .= "nom du constat: $NOM\n";
        $message .= "prenom du constat: $PRenom \n";
        $message .= "Date de décès: $decesDate\n";
        $message .= "Cause de décès: $causeDeDeces\n";
        $message .= "Identifiant de l'informant: $informantId\n";

        try {
            // Send the Twilio message
            $twilioClient->messages->create(
                '+21628824148', // Add your recipient phone number here
                [
                    'from' => $twilioPhoneNumber,
                    'body' => $message,
                ]
            );
        } catch (Exception $e) {
        }
    }

}








    