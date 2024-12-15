<?php

namespace App\Controller;

use App\Entity\Books;
use App\Entity\Loans;
use App\Entity\Comments;
use App\Form\BookRating;
use App\Repository\BooksRepository;
use App\Repository\LoansRepository;
use App\Repository\UsersRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BooksController extends AbstractController
{
    private $booksRepository;
    private $loansRepository;
    public function __construct(BooksRepository $booksRepository, LoansRepository $loansRepository, UsersRepository $usersRepository){
        $this->booksRepository = $booksRepository;
        $this->loansRepository = $loansRepository;
        $this->userRepository = $usersRepository;
    }

    #[Route('/books', name: 'index_books')]
    public function index(): Response
    {
        $books = $this->booksRepository->findAll();
        $loans = $this->loansRepository->findAll();

        return $this->render('books/index.html.twig', [
            'books'=> $books,
            'loans'=> $loans,
        ]);
    }

    #[Route('/books/{id}', name:'details_books')]
    public function show(Request $request, EntityManagerInterface $entityManager, Books $book): Response
    {
        $user = $this->getUser();
        $loans = $this->loansRepository->findAll();
         
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
            'loans'=> $loans,
            'user'=> $user,
        ]);
    }


    #[Route('/books/{id}/reserve', name: 'reserve_book')]
public function reserveBook(int $id, Request $request, EntityManagerInterface $entityManager): RedirectResponse
{
    $book = $entityManager->getRepository(Books::class)->find($id);

    $user = $this->getUser();
    $borrowDate = new \DateTime();

    $loan = new Loans();
    $loan->setBook($book);
    $loan->setDueDate((new \DateTime())->modify('+7 days'));
    $loan->setReturned(false);
    $loan->setExtension(false);
    $loan->setUser($user);
    $loan->setBorrowDate($borrowDate);

    $entityManager->persist($loan);
    $entityManager->flush();

    return $this->redirectToRoute('index_books');
}
}
