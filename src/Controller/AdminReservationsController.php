<?php

namespace App\Controller;

use App\Entity\Reservations;
use App\Repository\ReservationsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminReservationsController extends AbstractController
{
    #[Route('/admin/reservations', name: 'app_admin_reservations', methods:'GET')]
    public function viewAllReservations(ReservationsRepository $reservationsRepository, Reservations $reservations): Response
    {
        // Fetch all reservations from the repository
        $reservations = $reservationsRepository->findAll();

        return $this->render('admin/reservations.html.twig', [
            'reservations' => $reservations,
        ]);
    }
}