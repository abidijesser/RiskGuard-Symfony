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
use Dompdf\Dompdf;
use Dompdf\Options;

#[Route('/employee')]
class EmployeeController extends AbstractController
{

    #[Route('/home', name: 'app_employeefront_home', methods: ['GET'])]
    public function home(EmployeeRepository $employeeRepository): Response
    {
        return $this->render('employeeback/home.html.twig');

    }

    #[Route('/', name: 'app_employee_index', methods: ['GET'])]
    public function index(EmployeeRepository $employeeRepository): Response
    {
        return $this->render('employee/index.html.twig', [
            'employees' => $employeeRepository->findAll(),
        ]);

    }

    #[Route('/listem', name: 'app_employee_listem', methods: ['GET'])]
public function listem(EmployeeRepository $employeeRepository): Response
{
    // Reference the Dompdf namespace

    // Instantiate Dompdf with options
    $options = new Options();
    $options->set('defaultFont', 'Courier');
    $dompdf = new Dompdf($options);

    // Load HTML content
    $html = $this->renderView('employee/listem.html.twig', [
        'employees' => $employeeRepository->findAll(),
    ]);

    // Load HTML content into Dompdf
    $dompdf->loadHtml($html);

    // (Optional) Setup the paper size and orientation
    $dompdf->setPaper('A4', 'landscape');

    // Render the HTML as PDF
    $dompdf->render();

    // Output the generated PDF to Browser
    $dompdf->stream('employee_list.pdf');

    // Symfony Response object
    return new Response();
}





    #[Route('/new', name: 'app_employee_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $employee = new Employee();
        $form = $this->createForm(EmployeeType::class, $employee);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($employee);
            $entityManager->flush();

            return $this->redirectToRoute('app_employee_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('employee/new.html.twig', [
            'employee' => $employee,
            'form' => $form,
        ]);
    }




    





/*    #[Route('/employee/salaire-maximum', name: 'app_employee_salaire_maximum', methods: ['GET'])]
public function salaireMaximum(EmployeeRepository $employeeRepository): Response
{
    $employee = $employeeRepository->findEmployeeWithMaxSalaire();

    if (!$employee) {
        throw $this->createNotFoundException('Aucun employé trouvé');
    }

    return $this->render('employee/salaireem.html.twig', [
        'employee' => $employee,
    ]);
}*/
#[Route('/max-salary', name: 'employee_max_salary')]
    public function maxSalary(): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        
        // Récupérer l'employé avec le salaire maximum
        $maxSalaryEmployee = $entityManager->getRepository(Employee::class)->findOneBy([], ['salaire' => 'DESC']);
        
        if (!$maxSalaryEmployee) {
            throw $this->createNotFoundException('Aucun employé trouvé.');
        }
        
        return $this->render('employee/salairemax.html.twig', [
            'employee' => $maxSalaryEmployee,
        ]);
    }
    
    

    #[Route('/{id}', name: 'app_employee_show', methods: ['GET'])]
    public function show(Employee $employee): Response
    {
        return $this->render('employee/show.html.twig', [
            'employee' => $employee,
        ]);
    }
   


    #[Route('/{id}/edit', name: 'app_employee_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Employee $employee, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(EmployeeType::class, $employee);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_employee_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('employee/edit.html.twig', [
            'employee' => $employee,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_employee_delete', methods: ['POST'])]
    public function delete(Request $request, Employee $employee, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$employee->getId(), $request->request->get('_token'))) {
            $entityManager->remove($employee);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_employee_index', [], Response::HTTP_SEE_OTHER);
    }

    




}
