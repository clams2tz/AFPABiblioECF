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
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
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
        $bookId = $book->getId();
        $user = $this->getUser();
        $userId = $this->getUser()->getId();
        $loans = $this->loansRepository->findAll();
        // $loanUser = $this->loansRepository->findLastLoanByUser($user, $bookId);
    
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
            'userId'=> $userId, 
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

#[Route('/loans/{id}/extend', name: 'extend_loan')]
public function extendLoan(int $id, EntityManagerInterface $entityManager, Security $security, Loans $loan): RedirectResponse
{
    $dueDate = $loan->getDueDate();
    $newDueDate = \DateTimeImmutable::createFromMutable($dueDate)->add(new \DateInterval('P7D'));
    $loan->setDueDate(\DateTime::createFromImmutable($newDueDate));
    $loan->setExtension(true);
    $entityManager->flush();

    return $this->redirectToRoute('details_books', ['id' => $loan->getBook()->getId()]);
}

}
