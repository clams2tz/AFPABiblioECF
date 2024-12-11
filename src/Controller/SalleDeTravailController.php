<?php

namespace App\Controller;

use App\Repository\SalleDeTravailRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class SalleDeTravailController extends AbstractController
{
    private $sallesRepo;
    public function __construct(SalleDeTravailRepository $sallesRepo)
    {
        $this->sallesRepo = $sallesRepo;
    }
    #[Route('/salle_de_travail', name: 'details_salle')]
    public function show(): Response
    {
        $salles = $this->sallesRepo->findAll();
        return $this->render('salle_de_travail/index.html.twig', [
            'controller_name' => 'SalleDeTravailController',
            'salles'=> $this->sallesRepo->findAll(),
        ]);
    }

    #[Route('/', name: 'app_salle_de_travail')]
    public function index(): Response
    {
        $salles = $this->sallesRepo->findOne();
        return $this->render('salle_de_travail/index.html.twig', [
            'controller_name' => 'SalleDeTravailController',
            'salles' => $salles,
        ]);
    }
}
