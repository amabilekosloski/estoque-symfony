<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class PainelController extends AbstractController
{
    #[Route('/painel', name: 'app_dashboard')]
    public function index(): Response
    {
        return $this->render('painel/index.html.twig', [
            'controller_name' => 'PainelController',
        ]);
    }
}
