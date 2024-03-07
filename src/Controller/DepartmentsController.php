<?php

namespace App\Controller;

use App\Entity\Departments;
use App\Form\DepartmentsType;
use App\Repository\DepartmentsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/departments')]
class DepartmentsController extends AbstractController
{
    #[Route('/', name: 'app_departments_index', methods: ['GET'])]
    public function index(DepartmentsRepository $departmentsRepository): Response
    {
        return $this->render('departments/index.html.twig', [
            'departments' => $departmentsRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_departments_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $department = new Departments();
        $form = $this->createForm(DepartmentsType::class, $department);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($department);
            $entityManager->flush();

            return $this->redirectToRoute('app_departments_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('departments/new.html.twig', [
            'department' => $department,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_departments_show', methods: ['GET'])]
    public function show(Departments $department): Response
    {
        return $this->render('departments/show.html.twig', [
            'department' => $department,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_departments_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Departments $department, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(DepartmentsType::class, $department);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_departments_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('departments/edit.html.twig', [
            'department' => $department,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_departments_delete', methods: ['POST'])]
    public function delete(Request $request, Departments $department, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$department->getId(), $request->request->get('_token'))) {
            $entityManager->remove($department);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_departments_index', [], Response::HTTP_SEE_OTHER);
    }
}
