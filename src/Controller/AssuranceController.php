<?php

namespace App\Controller;

use App\Entity\Assurance;
use App\Form\AssuranceType;
use App\Repository\AssuranceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Dompdf\Dompdf;
use Dompdf\Options;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/assurance')]
class AssuranceController extends AbstractController
{
    #[Route('/', name: 'app_assurance_index', methods: ['GET'])]
    public function index(Request $request, AssuranceRepository $assuranceRepository, PaginatorInterface $paginator): Response
    {
        $query = $assuranceRepository->createQueryBuilder('a')
            ->getQuery();

        $assurances = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1), // Page number
            2 // Items per page
        );

        return $this->render('assurance/index.html.twig', [
            'assurances' => $assurances,
        ]);
    }


    #[Route('/front', name: 'app_assurance_indexfront', methods: ['GET'])]
    public function indexfront(AssuranceRepository $assuranceRepository): Response
    {
        return $this->render('assurance/indexfront.html.twig', [
            'assurances' => $assuranceRepository->findAll(),
        ]);
    }
    #[Route('/assurance/pdf/{id}', name: 'app_assurance_pdf')]
    public function generatePdf(assurance $assurance): Response
    {
        $html = $this->renderView('assurance/pdf_template.html.twig', [
            'assurance' => $assurance,
        ]);

        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');
        $pdfOptions->set('isHtml5ParserEnabled', true);
        $pdfOptions->set('isPhpEnabled', true);
        $pdfOptions->set('isHtml5ParserEnabled', true);
        $pdfOptions->set('isPhpEnabled', true);
        $pdfOptions->set('isPhpEnabled', true);
        $pdfOptions->set('isPhpEnabled', true);
        $pdfOptions->set('isPhpEnabled', true);


        $dompdf = new Dompdf($pdfOptions);
        $dompdf->loadHtml($html);

        // Set paper size (A4)
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        // Stream the generated PDF back to the user
        $output = $dompdf->output();

        $response = new Response($output);
        $response->headers->set('Content-Type', 'application/pdf');

        return $response;
    }

    #[Route('/new', name: 'app_assurance_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $assurance = new Assurance();
        $form = $this->createForm(AssuranceType::class, $assurance);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($assurance);
            $entityManager->flush();

            return $this->redirectToRoute('app_assurance_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('assurance/new.html.twig', [
            'assurance' => $assurance,
            'form' => $form->createView(),
        ]);
    }
    #[Route('/neww', name: 'app_assurance_newf', methods: ['GET', 'POST'])]
    public function newfff(Request $request, EntityManagerInterface $entityManager): Response
    {
        $assurance = new Assurance();
        $form = $this->createForm(AssuranceType::class, $assurance);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($assurance);
            $entityManager->flush();

            return $this->redirectToRoute('app_assurance_indexfront', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('assurance/newff.html.twig', [
            'assurance' => $assurance,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}/edit', name: 'app_assurance_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Assurance $assurance, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(AssuranceType::class, $assurance);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_assurance_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('assurance/edit.html.twig', [
            'assurance' => $assurance,
            'form' => $form->createView(),
        ]);
    }



    #[Route('/{id}', name: 'app_assurance_delete', methods: ['POST'])]
    public function delete(Request $request, Assurance $assurance, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$assurance->getId(), $request->request->get('_token'))) {
            $entityManager->remove($assurance);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_assurance_index', [], Response::HTTP_SEE_OTHER);
    }



    #[Route('/{id}', name: 'app_assurance_show', methods: ['GET'])]
    public function show(Assurance $assurance): Response
    {
        return $this->render('assurance/show.html.twig', [
            'assurance' => $assurance,
        ]);
    }




    //////catalogue client

    #[Route('/client/front ', name: 'app_assurance_indexclient', methods: ['GET'])]
    public function indexccc(AssuranceRepository $assuranceRepository, PaginatorInterface $paginator, Request $request): Response
    {
        // Récupérer toutes les assurances
        $assurances = $assuranceRepository->findAll();

        // Paginer les résultats
        $pagination = $paginator->paginate(
            $assurances, // Requête Doctrine
            $request->query->getInt('page', 1), // Numéro de page par défaut
            10 // Nombre d'éléments par page
        );

        return $this->render('assurance/frontclient.html.twig', [
            'pagination' => $pagination,
            'assurances' => $assurances,
        ]);
    }




//////////////////////////////////////////////////front
    #[Route('/frontshow/{id}', name: 'app_assurance_showfront', methods: ['GET'])]
public function showfront(Assurance $assurance): Response
{
    return $this->render('assurance/showfront.html.twig', [
        'assurance' => $assurance,
    ]);
}



    //////////////////////////////////////////////front
    #[Route('/{id}/editfronttt', name: 'app_assurance_editfronttt', methods: ['GET', 'POST'])]
    public function editfront(Request $request, Assurance $assurance, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(AssuranceType::class, $assurance);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_assurance_indexfront', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('assurance/editfront.html.twig', [
            'assurance' => $assurance,
            'form' => $form->createView(),
        ]);
    }





    #[Route('/delete/{id}', name: 'app_assurance_deletefront', methods: ['POST'])]
    public function deletefront(Request $request, Assurance $assurance, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$assurance->getId(), $request->request->get('_token'))) {
            $entityManager->remove($assurance);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_assurance_indexfront', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/statistiques/stat', name: 'app_assurance_statmehdi', methods: ['GET'])]
    public function statistiques(AssuranceRepository $assuranceRepository): Response
    {
        $statistiques = $assuranceRepository->countAssurancesVieAndVehicule();

        return $this->render('assurance/statistiques.html.twig', [
            'statistiques' => $statistiques,
        ]);
    }
}
