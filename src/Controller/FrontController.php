<?php

namespace App\Controller;

use App\Entity\Game;
use App\Form\CartAddType;
use App\Repository\GameRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class FrontController extends AbstractController
{
    #[Route('/', name: 'app_front')]
    public function index(GameRepository $gameRepository): Response
    {
        return $this->render('front/index.html.twig', [
            'games' => $gameRepository->findBy([], [], 10)

        ]);
    }

    #[Route('/game/{slug}', name: 'game')]
    public function gameDetails(#[MapEntity(mapping: ['slug' => 'slug'])] Game $game): Response
    {
        return $this->render('front/detail.html.twig', [
            'game' => $game,
        ]);
    }
}
