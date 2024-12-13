<?php

namespace App\Controller;

use App\Entity\Books;
use App\Repository\BooksRepository;
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

        $books = $this->booksRepository->getBooks();

        return $this->render('books/index.html.twig', [
            'controller_name' => 'BooksController',
            'books'=> $books,
        ]);
    }

    #[Route('/books/{id}', name:'details_books')]
    public function show(Books $book): Response
    {
        return $this->render('books/details.html.twig', [
            'book'=> $book,
        ]);
    }
}
