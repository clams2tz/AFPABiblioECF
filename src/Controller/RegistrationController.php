<?php

namespace App\Controller;

use App\Entity\Abonnement;
use App\Entity\Users;
use App\Form\RegistrationFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

class RegistrationController extends AbstractController
{
    #[Route('/register', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager): Response
    {
        $user = new Users();
        $abonnement = new Abonnement();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var string $plainPassword */
            $plainPassword = $form->get('plainPassword')->getData();

            // encode the plain password
            $user->setPassword($userPasswordHasher->hashPassword($user, $plainPassword));
            
            $chosenAbonnement = $form->get('subscription_type')->getData();
            $abonnement->setSubscriptionType($chosenAbonnement);
            
            $monthlyCost = 23.99;
            if($chosenAbonnement === 'annual') {
                $abonnement->setPrice($monthlyCost * 12);
            } else {
                $abonnement->setPrice($monthlyCost);
            }
            $abonnement->setRenewal(new \DateTime());
            
            
            $entityManager->persist($abonnement);
            $user->setAbonnement($abonnement);
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('app_login');
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form,
        ]);
    }
}
