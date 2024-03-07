<?php

namespace App\Controller;

use App\Entity\Employee;
use App\Form\EmployeeType;
use App\Repository\EmployeeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/employeefront')]
class EmployeefrontController extends AbstractController
{
    #[Route('/', name: 'app_employeefront_home', methods: ['GET'])]
    public function home(EmployeeRepository $employeeRepository): Response
    {
        return $this->render('employeefront/home.html.twig');

    }
    #[Route('/index', name: 'app_employeefront_index', methods: ['GET'])]
    public function index(EmployeeRepository $employeeRepository): Response
    {
        return $this->render('employeefront/index.html.twig', [
            'employees' => $employeeRepository->findAll(),
        ]);

    }

    #[Route('/admin', name: 'app_admin_index2', methods: ['GET'])]
    public function admin(): Response
    {
        return $this->render('admin/index2.html.twig', );
    }




    #[Route('/newfront', name: 'app_employeefront_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $employee = new Employee();
        $form = $this->createForm(EmployeeType::class, $employee);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($employee);
            $entityManager->flush();

            return $this->redirectToRoute('app_employeefront_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('employeefront/new.html.twig', [
            'employee' => $employee,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_employeefront_show', methods: ['GET'])]
    public function show(Employee $employee): Response
    {
        return $this->render('employeefront/show.html.twig', [
            'employee' => $employee,
        ]);
    }

    #[Route('/{id}/editfront', name: 'app_employeefront_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Employee $employee, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(EmployeeType::class, $employee);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_employeefront_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('employeefront/edit.html.twig', [
            'employee' => $employee,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_employeefront_delete', methods: ['POST'])]
    public function delete(Request $request, Employee $employee, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$employee->getId(), $request->request->get('_token'))) {
            $entityManager->remove($employee);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_employeefront_index', [], Response::HTTP_SEE_OTHER);
    }
}

