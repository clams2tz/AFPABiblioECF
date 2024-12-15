<?php

namespace App\Controller;
 
use App\Entity\Reservations;
use App\Form\ReservationType; 
use App\Entity\SalleDeTravail; 
use App\Repository\ReservationsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ReservationsController extends AbstractController
{
    private $security;  
     
    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    #[Route('/reservations/api', name: 'reservations_api')]
    public function reservationsApi(ReservationsRepository $reservationsRepository): Response
    {
        $reservations = $reservationsRepository->findAll();
        $events = [];

        foreach ($reservations as $reservation) {
            $events[] = [
                'title' => 'Réservé',
                'start' => $reservation->getStartTime()->format('Y-m-d\TH:i:s'),
                'end' => $reservation->getEndTime()->format('Y-m-d\TH:i:s'),
            ];
        }

        return $this->json($events);
    }

    #[Route('/salle/{id}', name: 'salle_details')]
    public function details(SalleDeTravail $salle, Request $request, ReservationsRepository $reservationsRepository, EntityManagerInterface $entityManager): Response
    {
        $user = $this->security->getUser();
        $reservation = new Reservations();
        $form = $this->createForm(ReservationType::class, $reservation);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $startTime = $reservation->getStartTime();
            $endTime = $reservation->getEndTime();
            $duration = $endTime->getTimestamp() - $startTime->getTimestamp();
        
            if ($startTime->format('H:i')< '08:00' || $endTime->format('H:i')>'19:00' || $startTime->format('N') > 5) {
            $this->addFlash('error', 'Le reservation ne respect pas nos horaires d\'ouverture.'); 
            } elseif ($duration < 3600 || $duration > 14400) {
                $this->addFlash('error', 'Le reservation doit durer entre 1h et 4h.'); 
            } else {
                $existingReservations = $reservationsRepository->findBy(['salle' => $salle]);
                $overlapping = false;
                foreach ($existingReservations as $existingReservation) {
                    if (($startTime < $existingReservation->getEndTime()) && ($endTime > $existingReservation->getStartTime())) {
                        $this->addFlash('error', 'La salle est déjà réservée pour cette période. Merci de consulter le calendrier de disponibilité.');
                        $overlapping = true;
                        break;
                    }
                }
                if (!$overlapping) {
                    $reservation->setSalle($salle);
                    $reservation->setUser($user);
                    $entityManager->persist($reservation);
                    $entityManager->flush();
                    return $this->redirectToRoute('salle_details', ['id' => $salle->getId()]);
                } 
            }
        }           
        return $this->render('reservations/reserve.html.twig', [
            'salle' => $salle,
            'form' => $form->createView(),
            'reservations' => $reservation,
        ]);
    }
    //         $reservation->setSalle($salle);
    //         $reservation->setUser($user);
    //         $entityManager->persist($reservation);
    //         $entityManager->flush();
    //         return $this->redirectToRoute('salle_details', ['id' => $salle->getId()]);

    //     }
    //     return $this->render('reservations/reserve.html.twig', [
    //         'salle' => $salle,
    //         'form' => $form->createView(),
    //         'reservations' => $reservation,
    //     ]);
    // }    
}
