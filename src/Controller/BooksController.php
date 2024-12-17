<?php

namespace App\Controller;

use App\Entity\Books;
use App\Entity\Loans;
use App\Entity\Comments;
use App\Form\BookRating;
use App\Repository\BooksRepository;
use App\Repository\LoansRepository;
use App\Repository\UsersRepository;
use App\Repository\CommentsRepository;
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
    public function __construct(BooksRepository $booksRepository, LoansRepository $loansRepository, UsersRepository $usersRepository)
    {
        $this->booksRepository = $booksRepository;
        $this->loansRepository = $loansRepository;
        $this->usersRepository = $usersRepository;
    }

    #[Route('/books', name: 'index_books')]
    public function index(): Response
    {
        $books = $this->booksRepository->findAll();
        $loans = $this->loansRepository->findAll();

        return $this->render('books/index.html.twig', [
            'books' => $books,
            'loans' => $loans,
        ]);
    }

    #[Route('/books/{id}', name: 'details_books')]
    public function show(Request $request, EntityManagerInterface $entityManager, Books $book, CommentsRepository $commentsRepository): Response
    {
        $bookId = $book->getId();
        $user = $this->getUser();
        $userId = $this->getUser()->getId();
        $loans = $this->loansRepository->findAll();
<<<<<<< HEAD

        if (!$user) {
            throw $this->createAccessDeniedException('You must be logged in to leave a comment.');
        }

=======
        // $loanUser = $this->loansRepository->findLastLoanByUser($user, $bookId);
    
>>>>>>> 21b73b2d94b045a8c5f07c7939594d0d4109425e
        $comment = new Comments();
        $showComments = $commentsRepository->findAll();  // to show comments
        $form = $this->createForm(BookRating::class, $comment);  // first param: which form, second param: to be mapped to which table in database
        $form->handleRequest($request);
        $form->get('rating')->getData();
        
        if ($form->isSubmitted() && $form->isValid()) {
            $comment->setDate(new \DateTime());
            $comment->setBook($book);
            $comment->setUser($user);

            $entityManager->persist($comment);
            $entityManager->flush();

            return $this->redirectToRoute('details_books', ['id' => $book->getId()]);
        }

        return $this->render('books/details.html.twig', [
<<<<<<< HEAD
            'book' => $book,
            'form' => $form->createView(),
            'loans' => $loans,
            'user' => $user,
            'showComments' => $showComments,
=======
            'book'=> $book,
            'form'=> $form->createView(),
            'loans'=> $loans,
            'userId'=> $userId, 
>>>>>>> 21b73b2d94b045a8c5f07c7939594d0d4109425e
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

<<<<<<< HEAD
        return $this->redirectToRoute('index_books');
    }
=======
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

>>>>>>> 21b73b2d94b045a8c5f07c7939594d0d4109425e
}
