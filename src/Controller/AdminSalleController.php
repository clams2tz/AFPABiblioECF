<?php

namespace App\Controller;

use App\Entity\Reservations;
use App\Repository\ReservationsRepository;
use App\Entity\SalleDeTravail;
use App\Form\SalleDeTravailType;
use App\Repository\SalleDeTravailRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/salle')]
final class AdminSalleController extends AbstractController
{
    #[Route(name: 'app_admin_salle_index', methods: ['GET'])]
    public function index(SalleDeTravailRepository $salleDeTravailRepository): Response
    {
        return $this->render('admin_salle/index.html.twig', [
            'salle_de_travails' => $salleDeTravailRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_admin_salle_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $salleDeTravail = new SalleDeTravail();
        $form = $this->createForm(SalleDeTravailType::class, $salleDeTravail);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($salleDeTravail);
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_salle_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin_salle/new.html.twig', [
            'salle_de_travail' => $salleDeTravail,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_salle_show', methods: ['GET'])]
    public function show(SalleDeTravail $salleDeTravail): Response
    {
        return $this->render('admin_salle/show.html.twig', [
            'salle_de_travail' => $salleDeTravail,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_salle_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, SalleDeTravail $salleDeTravail, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(SalleDeTravailType::class, $salleDeTravail);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_salle_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin_salle/edit.html.twig', [
            'salle_de_travail' => $salleDeTravail,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_salle_delete', methods: ['POST'])]
    public function delete(Request $request, SalleDeTravail $salleDeTravail, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$salleDeTravail->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($salleDeTravail);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_admin_salle_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/admin/reservations', name: 'app_admin_reservations', methods: ['GET'])]
    public function viewAllReservations(ReservationsRepository $reservationsRepository, Reservations $reservations): Response
    {
        // Fetch all reservations from the repository
        $reservations = $reservationsRepository->findAll();

        return $this->render('admin/reservations.html.twig', [
            'reservations' => $reservations,
        ]);
    }
}
