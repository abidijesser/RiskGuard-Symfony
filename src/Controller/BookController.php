<?php

namespace App\Controller;


use App\Entity\Books;
use App\Form\BookType;
use App\Repository\BooksRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BookController extends AbstractController
{
    #[Route('/book', name: 'app_book')]
    public function index(): Response
    {
        return $this->render('book/index.html.twig', [
            'controller_name' => 'BookController',
        ]);
    }



    #[Route('/addBook', name: 'add_book')]
    public function addBook(Request  $request,ManagerRegistry  $managerRegistry)
    {
        $book = new Books();
        $form= $this->createForm(BookType::class,$book);
        $form->add('valider',SubmitType::class);
        $form->handleRequest($request);
        $book->setPublished(true);
        if($form->isSubmitted()){
            $em= $managerRegistry->getManager();
            $nbBooks= $book->getAuthor()->getNbrBooks();
            //$book->setCategory("Action");
            //$book->setPublicationDate(new \DateTime());
            $book->getAuthor()->setNbrBooks($nbBooks+1);
            $em->persist($book);
            $em->flush();
            //var_dump($nbBooks).die();
            return $this->redirectToRoute('list_book');
        }
        return $this->renderForm("book/addbook.html.twig",array('formulaireBook'=>$form));
    }


    #[Route('/updateBook/{id}', name: 'Book_update')]
    public function updateAuthor(Request $request,BooksRepository $repository,$id,ManagerRegistry $managerRegistry)
    {
        $book = $repository->find($id);
        $form=$this->createForm(BookType::class,$book);
        $form->add('valider',SubmitType::class);
        $form->handleRequest($request);
        if($form->isSubmitted()){
        $em= $managerRegistry->getManager();
        $em->flush();
        //return $this->redirectToRoute("Books_list");
        }
        return $this->render("book/updateBook.html.twig",['f'=>$form->createView()]);
    }

    #[Route('/removeBook/{id}', name: 'book_remove')]
    public function deletebook($id,BooksRepository $repository,ManagerRegistry $managerRegistry)
    {
        $book= $repository->find($id);
        $em= $managerRegistry->getManager();
        $em->remove($book);
        $em->flush();
        return $this->redirectToRoute("list_book");
    }

    #[Route('/listBook/{id}', name: 'list_book')]
    public function listBook(BooksRepository  $repository,$id)
    {
        $books = $repository->findAll();
        $bookByAuthor = $repository->findBooksByAuthor($id);
        return $this->render("book/listBooks.html.twig",['tabBookByAuthor' => $bookByAuthor,'tabBooks' => $books]);
    }
}