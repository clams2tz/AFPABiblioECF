<?php

namespace App\Controller;

use App\Entity\Books;
use App\Entity\Loans;
use App\Form\BooksType;
use App\Repository\BooksRepository;
use App\Repository\LoansRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin/books')]
final class AdminBooksController extends AbstractController
{
    #[Route(name: 'app_admin_books_index', methods: ['GET'])]
    public function index(BooksRepository $booksRepository, LoansRepository $loansRepository): Response
    {
        return $this->render('admin_books/index.html.twig', [
            'books' => $booksRepository->findAll(),
            'loans' => $loansRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_admin_books_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $book = new Books();
        $form = $this->createForm(BooksType::class, $book);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($book);
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_books_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin_books/new.html.twig', [
            'book' => $book,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_books_show', methods: ['GET'])]
    public function show(Books $book): Response
    {
        return $this->render('admin_books/show.html.twig', [
            'book' => $book,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_books_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Books $book, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(BooksType::class, $book);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_books_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin_books/edit.html.twig', [
            'book' => $book,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_books_delete', methods: ['POST'])]
    public function delete(Request $request, Books $book, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$book->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($book);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_admin_books_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/admin/books', name: 'app_admin_books_index_retard', methods: ['GET'])]
    public function retardLoans(BooksRepository $booksRepository): Response
    {
        return $this->render('admin_books/index.html.twig', [
            'books' => $booksRepository->getNonRestituatedBooks(),
        ]);
    }

    #[Route('/admin/books/{id}', name: 'app_admin_books_index_restitution', methods: ['GET'])]
    public function restitutionLoans(BooksRepository $booksRepository, LoansRepository $loansRepository, EntityManagerInterface $entityManager, Books $book): Response
    {
        
        $latestLoan = $loansRepository->findLatestLoanByBook($book);
    
        if ($latestLoan) {
            $latestLoan->setReturned(true);
            $latestLoan->setDateFinalRestitution(new \DateTime());
    
            $entityManager->persist($latestLoan);
            $entityManager->flush();
        }
    
        return $this->redirectToRoute('app_admin_books_index'); // Redirection vers la liste des livres
    }

//     #[Route('/{idBook}/{idLoan}/restitution', name: 'book_restitution')]
//     public function restituateBook(Books $book,Loans $loan, EntityManagerInterface $entityManager): RedirectResponse
// {
//     $entityManager->persist($book);
//     $actualDate = new \DateTime();

//     $loan->setReturned(true);
//     $loan->setDateFinalRestitution($actualDate);

//     $entityManager->persist($loan);
//     $entityManager->flush();

//     return $this->redirectToRoute('app_admin_books_index');
// }
}
