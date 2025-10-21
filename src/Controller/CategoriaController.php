<?php

namespace App\Controller;

use App\Entity\Categoria;
use App\Repository\CategoriaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CategoriaController extends AbstractController
{
    public function __construct(
        private CategoriaRepository $categoriaRepository,
    ) {}

    #[Route('/categorias/cadastrar', name: 'cadastrar_categoria_show', methods: ['GET'])]
    public function show(): Response
    {
        return $this->render('app/categoria/cadastrar.html.twig');
    }

    #[Route('/categorias/cadastrar', name: 'cadastrar_categoria_salvar', methods: ['POST'])]
    public function salvar(Request $request): Response
    {
        $nomeCategoria = $request->request->get('nome');

        if (strlen($nomeCategoria) > 50) {
            $this->addFlash('danger', 'Nome deve ter no máximo 50 caracteres!');
            return $this->redirectToRoute('cadastrar_categoria_show');
        }

        $categoriaExistente = $this->categoriaRepository->findBy(['nome' => $nomeCategoria]);
        if ($categoriaExistente) {
            $this->addFlash('danger', "Categoria com nome \"{$nomeCategoria}\" já existe!");
            return $this->redirectToRoute('cadastrar_categoria_show');
        }

        $categoria = new Categoria();
        $categoria->setNome($nomeCategoria);

        $this->categoriaRepository->salvar($categoria);

        $this->addFlash('success', 'Categoria cadastrada com sucesso!');
        return $this->redirectToRoute('listar_categorias');
    }

    #[Route('/categorias/{id}', name: 'editar_categoria', methods: ['GET'])]
    public function editar(Request $request, Categoria $categoria): Response
    {
        $nome = $request->query->get('nome');

        if ($nome && strlen($nome) <= 50) {
            $categoria->setNome($nome);
            $this->categoriaRepository->salvar($categoria);
            $this->addFlash('success', 'Categoria atualizada!');
        } else {
            $this->addFlash('danger', 'Nome inválido!');
        }

        return $this->redirectToRoute('listar_categorias');
    }


    #[Route('/categorias/remover/{id}', name: 'remover_categoria', methods: ['GET'])]
    public function remover(Categoria $categoria): Response
    {
        $this->categoriaRepository->remover($categoria);

        $this->addFlash('success', 'Categoria removida com sucesso!');

        return $this->redirectToRoute('listar_categorias');
    }
}
