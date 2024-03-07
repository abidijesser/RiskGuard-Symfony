<?php

namespace App\Controller;

use App\Entity\Marketing;
use App\Entity\Commentaire;
use App\Form\MarketingType;
use App\Form\CommentaireType;
use App\Repository\CategorieRepository;
use App\Repository\MarketingRepository;
use Doctrine\ORM\EntityManagerInterface;
use Dompdf\Dompdf;
use Dompdf\Options;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\UploadedFile;


#[Route('/marketing')]
class MarketingController extends AbstractController
{
    #[Route('/admin', name: 'app_marketing_index', methods: ['GET', 'POST'])]
    public function indexAdmin(MarketingRepository $marketingRepository, Request $request, EntityManagerInterface $entityManager): Response
    {

        $marketing = new Marketing();
        $form = $this->createForm(MarketingType::class, $marketing);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $imageFile = $form->get('image')->getData();
            $fileName = 'marketing' . '-' . uniqid() . '.' . $imageFile->guessExtension();
            $imageFile->move(
                $this->getParameter('kernel.project_dir') . '/public/uploads/images',
                $fileName
            );

            // check if date fin is lower than current date

            if ($marketing->getDateFin() > new \DateTime()) {
                $marketing->setStatus('Active');
            } else {
                $marketing->setStatus('Finished');
            }

            $marketing->setImage('uploads/' . '/images' . '/' . $fileName);
            $entityManager->persist($marketing);
            $entityManager->flush();

            $marketingRepository->sms();

            return $this->redirectToRoute('app_marketing_index', [], Response::HTTP_SEE_OTHER);
        }
        return $this->renderForm('marketing/Marketing.html.twig', [
            'marketings' => $marketingRepository->findAll(),
            'form' => $form,
        ]);
    }

    #[Route('/pdf', name: 'PDF_marketing')]
    public function pdf(MarketingRepository $marketingRepository)
    {
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Open Sans');

        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);
        // Retrieve the HTML generated in our twig file
        $html = $this->renderView('marketing/pdf.html.twig', [
            'marketings' => $marketingRepository->findAll(),
        ]);

        // Add header HTML to $html variable
        $headerHtml = '<h1 style="text-align: center; color: #b00707;">Liste des evenements</h1>';
        $html = $headerHtml . $html;

        // Load HTML to Dompdf
        $dompdf->loadHtml($html);
        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();
        // Output the generated PDF to Browser (inline view)

        $pdfContent = $dompdf->output();

        $response = new Response(
            $pdfContent,
            Response::HTTP_OK,
            [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'attachment; filename="evenements.pdf"',
            ]
        );
    
        return $response;

    }

    #[Route('/', name: 'app_marketing_indexx')]
    public function index(MarketingRepository $marketingRepository, CategorieRepository $categorieRepository, Request $request, EntityManagerInterface $entityManager): Response
    {
        $marketings = $marketingRepository->findAll();
        $categories = $categorieRepository->findAll();

        
        return $this->render('marketing/Marketing_client.html.twig', [
            'marketings' => $marketings,
            'categories' => $categories,
        ]);
    }

    #[Route('/test', name: 'app_marketing_template')]
    public function template(): Response
    {

        return $this->render('marketing/indexTemplate.html.twig');
    }

    #[Route('/client', name: 'app_marketing_client')]
    public function client(): Response
    {

        return $this->render('marketing/marketing_client.html.twig');
    }

    #[Route('/new', name: 'app_marketing_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $marketing = new Marketing();
        $form = $this->createForm(MarketingType::class, $marketing);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($marketing);
            $entityManager->flush();
            

            return $this->redirectToRoute('app_marketing_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('marketing/new.html.twig', [
            'marketing' => $marketing,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_front_marketing_show', methods: ['GET', 'POST'])]
    public function showFront(Marketing $marketing,Request $request, EntityManagerInterface $entityManager): Response
    {
        $comment=new Commentaire();
        $form = $this->createForm(CommentaireType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $comment->setMarketing($marketing);
            $comment->setTimeStampp();
            $entityManager->persist($comment);
            $entityManager->flush();
            

            return $this->redirectToRoute('app_front_marketing_show', ['id' => $marketing->getId()]);
        }
        return $this->render('marketing/show_front.html.twig', [
            'marketing' => $marketing,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'app_marketing_show', methods: ['GET'])]
    public function show(Marketing $marketing): Response
    {
        return $this->render('marketing/show_marketing.html.twig', [
            'marketing' => $marketing,
        ]);
    }


    #[Route('/{id}/edit', name: 'app_marketing_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Marketing $marketing, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(MarketingType::class, $marketing);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $imageFile = $form->get('image')->getData();

            // Only process if a new image file is uploaded
            if ($imageFile instanceof UploadedFile) {
                $fileName = 'marketing' . '-' . uniqid() . '.' . $imageFile->guessExtension();
                $imageFile->move(
                    $this->getParameter('kernel.project_dir') . '/public/uploads/images',
                    $fileName
                );

                // Update the 'image' property to store the new file name
                $marketing->setImage('uploads/images/' . $fileName);
            }

            $entityManager->flush();

            return $this->redirectToRoute('app_marketing_index');
        }

        return $this->renderForm('marketing/edit.html.twig', [
            'marketing' => $marketing,
            'form' => $form,
        ]);
    }

    #[Route('/delete/{id}', name: 'app_marketing_delete')]
    public function delete(Request $request, Marketing $marketing, EntityManagerInterface $entityManager): Response
    {
        
            $entityManager->remove($marketing);
            $entityManager->flush();
        

        return $this->redirectToRoute('app_marketing_index');
    }
}
