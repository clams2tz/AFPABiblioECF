<?php

namespace App\Controller;

use App\Entity\Users;
use App\Form\UsersType;
use App\Entity\Comments;
use App\Entity\Abonnement;
use App\Repository\UsersRepository;
use App\Repository\CommentsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


#[Route('/admin')]
#[IsGranted('ROLE_ADMIN')]
final class AdminController extends AbstractController
{
    #[Route('/', name: 'app_admin_index', methods: ['GET'])]
    public function index(UsersRepository $usersRepository): Response
    {
        return $this->render('users/index.html.twig', [
            'users' => $usersRepository->findAll(),
        ]);
    }

    #[Route('/{id}', name: 'app_admin_delete', methods: ['POST'])]
    public function delete(Request $request, Users $user, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $user->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_admin_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/comments', name: 'comment_list')]
    public function showComments(CommentsRepository $commentsRepository): Response
    {
        $user = $this->getUser();
        if (!$user) {
            throw $this->createAccessDeniedException('You must be logged in to leave a comment.');
        }

        $comments = $commentsRepository->findAll();  // to show comments
        $commentByUser = $commentsRepository->findByUser($user);


        return $this->render('admin/admin_comment.html.twig', [
            'user' => $user,
            'comments' => $comments,
            'userComent' => $commentByUser,
        ]);
    }

    #[Route('/comments/user/{id}', name: 'comment_by_user', methods: ['GET'])]
    public function commentByUser(CommentsRepository $commentsRepository, Users $user): Response
    {
        $userComments = $commentsRepository->findBy([
            'user' => $user,
        ]);

        return $this->render('admin/comment_by_user.html.twig', [
            'user' => $user,
            'comments' => $userComments,
        ]);
    }

    #[Route('/register', name: 'admin_register_user', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, UserPasswordHasherInterface $userPasswordHasher): Response
    {

        $user = new Users();
        $abonnement = new Abonnement();
        $form = $this->createForm(UsersType::class, $user, [
            'is_authenticated' => $this->getUser() !== null,
        ]);
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
                $renewalDate = new \DateTime();
                $renewalDate->modify('+12 months');
                $abonnement->setRenewal($renewalDate);
            } else {
                $abonnement->setPrice($monthlyCost);
                $renewalDate = new \DateTime();
                $renewalDate->modify('+1 months');
                $abonnement->setRenewal($renewalDate);
            }

            $entityManager->persist($abonnement);
            $user->setAbonnement($abonnement);  // to inject data to abonnement table through user table \\
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_index');
        }

        return $this->render('admin/new.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/comments/{id}/delete', name: 'comment_delete', methods: ['POST'])]
    public function deleteComment(Request $request, Comments $comment, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete_comment_' . $comment->getId(), $request->get('_token'))) {
            $entityManager->remove($comment);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_admin_index', ['id' => $comment->getId()]); 
    }
}
