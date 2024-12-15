<?php

namespace App\Controller;

use App\Entity\Users;
use App\Enum\UserRole;
use App\Form\UsersType;
use App\Entity\Abonnement;
use App\Repository\LoansRepository;
use App\Repository\ReservationsRepository;
use App\Repository\UsersRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


//////////// All users (list)
#[Route('/users')]
final class UsersController extends AbstractController
{
    #[Route(name: 'app_users_index', methods: ['GET'])]
    #[IsGranted('ROLE_ADMIN')]
    public function index(UsersRepository $usersRepository): Response
    {
        return $this->render('users/index.html.twig', [
            'users' => $usersRepository->findAll(),
        ]);
    }

    /////////// ADD user (register)
    #[Route('/register', name: 'app_users_register', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, UserPasswordHasherInterface $userPasswordHasher): Response
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('index_books');
        }

        $user = new Users();
        $abonnement = new Abonnement();
        $form = $this->createForm(UsersType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var string $plainPassword */
            $plainPassword = $form->get('plainPassword')->getData();

            // encode the plain password
            $user->setPassword($userPasswordHasher->hashPassword($user, $plainPassword));

            $chosenAbonnement = $form->get('subscriptionType')->getData();
            $abonnement->setSubscriptionType($chosenAbonnement);

            $monthlyCost = 23.99;
            if ($chosenAbonnement === 'annual') {
                $abonnement->setPrice($monthlyCost * 12);
            } else {
                $abonnement->setPrice($monthlyCost);
            }
            $abonnement->setRenewal(new \DateTime());


            $entityManager->persist($abonnement);
            $user->setAbonnement($abonnement);  // to inject data to abonnement table through user table \\
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('app_users_index');
            // return $this->redirectToRoute('app_users_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('users/new.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /////////////////// user dashboard 
    #[Route('/profile', name: 'app_users_show', methods: ['GET'])]
    public function show(LoansRepository $loansRepository, ReservationsRepository $resevationsRepository): Response
    {
        $user = $this->getUser();
        if (!$user) {
            throw $this->createAccessDeniedException('You must be logged in to access this page.');
        }

        $loans = $loansRepository->findByUser($user);
        $reservations = $resevationsRepository->findByUser($user);

        return $this->render('users/show.html.twig', [
            'user' => $user,
            'loans' => $loans,
            'reservations' => $reservations,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_users_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Users $user, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(UsersType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $userRoleEnum = UserRole::from($form->get('roles')->getData());
            $user->setRoles($userRoleEnum);
            $entityManager->flush();

            return $this->redirectToRoute('app_users_show');
        }

        return $this->render('users/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'app_users_delete', methods: ['POST'])]
    public function delete(Request $request, Users $user, EntityManagerInterface $entityManager): Response
    {
        // if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->getPayload()->getString('_token'))) {
        if ($this->isCsrfTokenValid('delete' . $user->getId(), $request->request->get('_token'))) {
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_index', [], Response::HTTP_SEE_OTHER);
    }
}
