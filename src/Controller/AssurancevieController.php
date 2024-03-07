<?php

namespace App\Controller;

use App\Entity\Assurancevie;
use App\Form\AssurancevieType;
use App\Repository\AssuranceRepository;
use App\Repository\AssurancevieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/assurancevie')]
class AssurancevieController extends AbstractController
{
    #[Route('/', name: 'app_assurancevie_index', methods: ['GET'])]
    public function index(AssurancevieRepository $assurancevieRepository): Response
    {
        return $this->render('assurancevie/index.html.twig', [
            'assurancevies' => $assurancevieRepository->findAll(),
        ]);
    }
    #[Route('/front', name: 'app_assurancevie_indexfront', methods: ['GET'])]
    public function indexfront(AssurancevieRepository $assurancevieRepository): Response
    {
        return $this->render('assurancevie/indexfront.html.twig', [
            'assurancevies' => $assurancevieRepository->findAll(),
        ]);
    }
    #[Route('/new', name: 'app_assurancevie_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $assurancevie = new Assurancevie();
        $form = $this->createForm(AssurancevieType::class, $assurancevie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($assurancevie);
            $entityManager->flush();

            return $this->redirectToRoute('app_assurancevie_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('assurancevie/new.html.twig', [
            'assurancevie' => $assurancevie,
            'form' => $form,
        ]);
    }
    #[Route('/newf', name: 'app_assurancevie_newfront', methods: ['GET', 'POST'])]
    public function newfront(Request $request, EntityManagerInterface $entityManager): Response
    {
        $assurancevie = new Assurancevie();
        $form = $this->createForm(AssurancevieType::class, $assurancevie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file = $form['fichedepaie']->getData();
            $fileName = uniqid().'.'.$file->guessExtension();

            $file->move(
                $this->getParameter('image_directory'),
                $fileName
            );

            $assurancevie->setFichedepaie($fileName);
            $entityManager->persist($assurancevie);
            $entityManager->flush();

            return $this->redirectToRoute('app_assurancevie_indexfront', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('assurancevie/newfront.html.twig', [
            'assurancevie' => $assurancevie,
            'form' => $form,
        ]);
    }


    #[Route('/{id}', name: 'app_assurancevie_show', methods: ['GET'])]
    public function show(Assurancevie $assurancevie): Response
    {
        return $this->render('assurancevie/show.html.twig', [
            'assurancevie' => $assurancevie,
        ]);
    }


    #[Route('/front/{id}', name: 'app_assurancevie_showfront', methods: ['GET'])]
    public function showf(Assurancevie $assurancevie): Response
    {
        return $this->render('assurancevie/showfront.html.twig', [
            'assurancevie' => $assurancevie,
        ]);
    }



    #[Route('/{id}/edit', name: 'app_assurancevie_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Assurancevie $assurancevie, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(AssurancevieType::class, $assurancevie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            $file = $form['fichedepaie']->getData();
            $fileName = uniqid().'.'.$file->guessExtension();

            $file->move(
                $this->getParameter('image_directory'),
                $fileName
            );

            $assurancevie->setFichedepaie($fileName);
            return $this->redirectToRoute('app_assurancevie_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('assurancevie/edit.html.twig', [
            'assurancevie' => $assurancevie,
            'form' => $form,
        ]);
    }
    #[Route('/{id}/editf', name: 'app_assurancevie_editfront', methods: ['GET', 'POST'])]
    public function editf(Request $request, Assurancevie $assurancevie, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(AssurancevieType::class, $assurancevie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file = $form['fichedepaie']->getData();
            $fileName = uniqid().'.'.$file->guessExtension();

            $file->move(
                $this->getParameter('image_directory'),
                $fileName
            );

            $assurancevie->setFichedepaie($fileName);
            $entityManager->flush();

            return $this->redirectToRoute('app_assurancevie_indexfront', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('assurancevie/editfront.html.twig', [
            'assurancevie' => $assurancevie,
            'form' => $form,
        ]);
    }
    #[Route('/{id}', name: 'app_assurancevie_delete', methods: ['POST'])]
    public function delete(Request $request, Assurancevie $assurancevie, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$assurancevie->getId(), $request->request->get('_token'))) {
            $entityManager->remove($assurancevie);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_assurancevie_index', [], Response::HTTP_SEE_OTHER);
    }
        #[Route('/stat/avgsalaire', name: 'app_assurance_statistiques', methods: ['GET'])]
        public function statistiquesavgsalaire(AssuranceRepository $assuranceRepository): Response
        {
            $salaireStats = $assuranceRepository->calculateSalaireStatsForAssurancesVie();

            return $this->render('assurancevie/avgsalaire.html.twig', [
                'salaireStats' => $salaireStats,
            ]);
        }


        #[Route('/trier-par-salaire/trie', name: 'trier_par_salaire')]
        public function trierParSalaire(AssurancevieRepository $assurancevieRepository): Response
        {
            $assurancevies = $assurancevieRepository->findAllSortedBySalaire();

            return $this->render('assurancevie/trier_par_salaire.html.twig', [
                'assurancevies' => $assurancevies,
            ]);
        }


    }
