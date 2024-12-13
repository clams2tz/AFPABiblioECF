<?php

namespace App\Controller;

use App\Entity\Books;
use App\Entity\Comments;
use App\Form\BookRating;
use App\Repository\BooksRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BooksController extends AbstractController
{
    private $booksRepository;
    public function __construct(BooksRepository $booksRepository){
        $this->booksRepository = $booksRepository;
    }

    #[Route('/books', name: 'index_books')]
    public function index(): Response
    {
        $books = $this->booksRepository->findAll();
        return $this->render('books/index.html.twig', [
            'books'=> $books,
        ]);
    }

    #[Route('/books/{id}', name:'details_books')]
    public function show(Request $request, EntityManagerInterface $entityManager, Books $book): Response
    {
        $user = $this->getUser(); 
        if (!$user) {
            throw $this->createAccessDeniedException('You must be logged in to leave a comment.');
        }
    
        $comment = new Comments();
        $form = $this->createForm(BookRating::class, $comment);  // first param: which form, second param: to be mapped to which table in database
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $comment->setDate(new \DateTime());
            $comment->setBook($book);
            $comment->setUser($user);
    
            $entityManager->persist($comment);
            $entityManager->flush();
    
            return $this->redirectToRoute('details_books', ['id' => $book->getId()]);
        }


        return $this->render('books/details.html.twig', [
            'book'=> $book,
            'form'=> $form->createView(),
        ]);
    }
}
