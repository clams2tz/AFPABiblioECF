<?php

namespace App\Controller;

use id;
use App\Repository\SalleDeTravailRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SalleDeTravailController extends AbstractController
{
    private $sallesRepo;
    public function __construct(SalleDeTravailRepository $sallesRepo)
    {
        $this->sallesRepo = $sallesRepo;
    }
    #[Route('/salles', name: 'app_salle_de_travail')]
    public function index(): Response
    {
        $salles = $this->sallesRepo->findAll();

        return $this->render('salle_de_travail/index.html.twig', [
            'controller_name' => 'SalleDeTravailController',
            'salles'=> $salles,
        ]);
    }

    #[Route('/salle/{id}', name: 'salle_details')]
    public function details($id): Response
    {
        $salle = $this->sallesRepo->find($id);

        return $this->render('salle_de_travail/details.html.twig', [
            'salle' => $salle,
        ]);
    }
}
