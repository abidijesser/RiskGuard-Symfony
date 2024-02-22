<?php

namespace App\Controller;

use App\Entity\Marketing;
use App\Entity\Commentaire;
use App\Form\MarketingType;
use App\Form\CommentaireType;
use App\Repository\MarketingRepository;
use Doctrine\ORM\EntityManagerInterface;
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
            $entityManager->persist($marketing);
            $entityManager->flush();

            return $this->redirectToRoute('app_marketing_index', [], Response::HTTP_SEE_OTHER);
        }
        return $this->renderForm('marketing/Marketing.html.twig', [
            'marketings' => $marketingRepository->findAll(),
            'form' => $form,
        ]);
    }

    #[Route('/', name: 'app_marketing_indexx')]
    public function index(MarketingRepository $marketingRepository, Request $request, EntityManagerInterface $entityManager): Response
    {
        $marketings = $marketingRepository->findAll();
        
        return $this->render('marketing/Marketing_client.html.twig', [
            'marketings' => $marketings,
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
