<?php

namespace App\Controller;

use App\Entity\Assurancevehicule;
use App\Form\AssurancevehiculeType;
use App\Repository\AssurancevehiculeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twilio\Exceptions\ConfigurationException;
use Twilio\Exceptions\TwilioException;
use Twilio\Rest\Client;

#[Route('/assurancevehicule')]
class AssurancevehiculeController extends AbstractController
{
    #[Route('/', name: 'app_assurancevehicule_index', methods: ['GET'])]
    public function index(AssurancevehiculeRepository $assurancevehiculeRepository): Response
    {
        return $this->render('assurancevehicule/index.html.twig', [
            'assurancevehicules' => $assurancevehiculeRepository->findAll(),
        ]);
    }
    #[Route('/front', name: 'app_assurancevehicule_indexfront', methods: ['GET'])]
    public function indexaa(AssurancevehiculeRepository $assurancevehiculeRepository): Response
    {
        return $this->render('assurancevehicule/indexfront.html.twig', [
            'assurancevehicules' => $assurancevehiculeRepository->findAll(),
        ]);
    }


    #[Route('/new', name: 'app_assurancevehicule_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $assurancevehicule = new Assurancevehicule();
        $form = $this->createForm(AssurancevehiculeType::class, $assurancevehicule);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file = $form['image']->getData();
            $fileName = uniqid().'.'.$file->guessExtension();

            // Move the file to the directory where your images are stored
            $file->move(
                $this->getParameter('image_directory'),
                $fileName
            );

            // Set the 'image' property with the file name
            $assurancevehicule->setImage($fileName);
            $entityManager->persist($assurancevehicule);
            $entityManager->flush();

            return $this->redirectToRoute('app_assurancevehicule_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('assurancevehicule/new.html.twig', [
            'assurancevehicule' => $assurancevehicule,
            'form' => $form->createView(),
        ]);
    }
    #[Route('/newfront', name: 'app_assurancevehicule_newfront', methods: ['GET', 'POST'])]
    public function newvehicule(Request $request, EntityManagerInterface $entityManager): Response
    {
        $assurancevehicule = new Assurancevehicule();
        $form = $this->createForm(AssurancevehiculeType::class, $assurancevehicule);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file = $form['image']->getData();
            $fileName = uniqid().'.'.$file->guessExtension();

            // Move the file to the directory where your images are stored
            $file->move(
                $this->getParameter('image_directory'),
                $fileName
            );

            // Set the 'image' property with the file name
            $assurancevehicule->setImage($fileName);
            $entityManager->persist($assurancevehicule);
            $entityManager->flush();
            $this->sendTwilioMessage($assurancevehicule);

            return $this->redirectToRoute('app_assurancevehicule_indexfront', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('assurancevehicule/newfrontvehicule.html.twig', [
            'assurancevehicule' => $assurancevehicule,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'app_assurancevehicule_show', methods: ['GET'])]
    public function show(Assurancevehicule $assurancevehicule): Response
    {
        return $this->render('assurancevehicule/show.html.twig', [
            'assurancevehicule' => $assurancevehicule,
        ]);
    }

    #[Route('/showf/{id}', name: 'app_assurancevehicule_showfrontt', methods: ['GET'])]
public function showcc(Assurancevehicule $assurancevehicule): Response
{
    return $this->render('assurancevehicule/showvfront.html.twig', [
        'assurancevehicule' => $assurancevehicule,
    ]);
}

    #[Route('/{id}/editfront', name: 'app_assurancevehicule_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Assurancevehicule $assurancevehicule, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(AssurancevehiculeType::class, $assurancevehicule);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file = $form['image']->getData();
            $fileName = uniqid().'.'.$file->guessExtension();

            // Move the file to the directory where your images are stored
            $file->move(
                $this->getParameter('image_directory'),
                $fileName
            );

            $assurancevehicule->setImage($fileName);
            $entityManager->flush();

            return $this->redirectToRoute('app_assurancevehicule_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('assurancevehicule/edit.html.twig', [
            'assurancevehicule' => $assurancevehicule,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}/edit', name: 'app_assurancevehicule_editfront', methods: ['GET', 'POST'])]
    public function editfront(Request $request, Assurancevehicule $assurancevehicule, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(AssurancevehiculeType::class, $assurancevehicule);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $file = $form['image']->getData();
            if ($file) {
                // Handle file upload logic
            }

            dump($assurancevehicule->getImage());

            $entityManager->flush();

            return $this->redirectToRoute('app_assurancevehicule_indexfront', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('assurancevehicule/editfront.html.twig', [
            'assurancevehicule' => $assurancevehicule,
            'form' => $form->createView(),
        ]);
    }





    #[Route('/{id}', name: 'app_assurancevehicule_delete', methods: ['POST'])]
    public function delete(Request $request, Assurancevehicule $assurancevehicule, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$assurancevehicule->getId(), $request->request->get('_token'))) {
            $entityManager->remove($assurancevehicule);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_assurancevehicule_index', [], Response::HTTP_SEE_OTHER);
    }

    /**
     * @throws ConfigurationException
     * @throws TwilioException
     */
    private function sendTwilioMessage(Assurancevehicule $assurancevehicule): void
    {
        $twilioAccountSid = $this->getParameter('twilio_account_sid');
        $twilioAuthToken = $this->getParameter('twilio_auth_token');
        $twilioPhoneNumber = $this->getParameter('twilio_phone_number');

        $twilioClient = new Client($twilioAccountSid, $twilioAuthToken);

        // Replace 'to' with the recipient phone number
        // Replace 'from' with your Twilio phone number
        $twilioClient->messages->create(
            '+21651570009', 
            [
                'from' => $twilioPhoneNumber,
                'body' => 'your  assurance vehicule has been created: ' . $assurancevehicule->getMarque(),
            ]
        );
    }
}
