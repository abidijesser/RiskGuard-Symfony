<?php

namespace App\Controller;

use App\Entity\Author;
use App\Form\AuthorType;
use App\Repository\AuthorRepository;
use App\Repository\BooksRepository;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;




class AuthorController extends AbstractController
{
    #[Route('/author', name: 'app_author')]
    public function index(): Response
    {
        return $this->render('author/index.html.twig', [
            'controller_name' => 'AuthorController',
        ]);
    }



    #[Route('/authorsList', name: 'authors_list')]
    public function list(AuthorRepository $repository)
    {
        $authors= $repository->findAll();
        return $this->render("author/listAuthors.html.twig",array("tabAuthors"=>$authors));
    }

    #[Route('/addAuthor', name: 'author_add')]
    public function addAuthor(Request $request,ManagerRegistry $managerRegistry)
    {
        $author = new  Author();
        $form=$this->createForm(AuthorType::class,$author);
        $form->add('valider',SubmitType::class);
        $form->handleRequest($request);
        
        if($form->isSubmitted()){
            $em= $managerRegistry->getManager();
            $em->persist($author);
            $em->flush();
            return $this->redirectToRoute('authors_list');
        }
        return $this->render("author/add.html.twig", ['f' => $form->createView()]);
    }

    #[Route('/updateAuthor/{id}', name: 'author_update')]
    public function updateAuthor(Request $request,AuthorRepository $repository,$id,ManagerRegistry $managerRegistry)
    {
        $author = $repository->find($id);
        $form=$this->createForm(AuthorType::class,$author);
        $form->add('valider',SubmitType::class);
        $form->handleRequest($request);
        if($form->isSubmitted()){
        $em= $managerRegistry->getManager();
        $em->flush();
        //return $this->redirectToRoute("authors_list");
        }
        return $this->render("author/updateAuthor.html.twig",['f'=>$form->createView()]);
    }

    #[Route('/removeAuthor/{id}', name: 'author_remove')]
    public function deleteAuthor($id,AuthorRepository $repository,ManagerRegistry $managerRegistry)
    {
        $author= $repository->find($id);
        $em= $managerRegistry->getManager();
        $em->remove($author);
        $em->flush();
        return $this->redirectToRoute("authors_list");
    }


    #[Route('/authorsList', name: 'authors_list')]
    public function listAuthors(AuthorRepository $repository)
    {
    $authorsByEmail = $repository->showAllAuthorsOrderByEmail();
    $allAuthors = $repository->findAll();

    return $this->render("author/listAuthors.html.twig", ['tabAuthorsByEmail' => $authorsByEmail,'tabAuthorsAll' => $allAuthors,]);
    }

}