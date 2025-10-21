<?php

namespace App\Controller;

use App\Repository\CategoriaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ListarController extends AbstractController
{
    public function __construct(
        private CategoriaRepository $categoriaRepository,
    ){        
    }


    #[Route('/categorias', name: 'listar_categorias', methods: ['GET'])]
    public function show(): Response
    {
        return $this->render('listar/listar.html.twig', [
            'categorias' => $this->categoriaRepository->findAll(),
        ]);
    }
}
