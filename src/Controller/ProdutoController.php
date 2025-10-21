<?php

namespace App\Controller;

use App\Entity\Produto;
use App\Form\ProdutoType;
use App\Repository\ProdutoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/produto')]
class ProdutoController extends AbstractController
{
    #[Route('/', name: 'listar_produtos', methods: ['GET'])]
    public function index(ProdutoRepository $produtoRepository): Response
    {
        return $this->render('app/produto/index.html.twig', [
            'produtos' => $produtoRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'cadastrar_produto', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $produto = new Produto();
        $form = $this->createForm(ProdutoType::class, $produto);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($produto);
            $entityManager->flush();

            return $this->redirectToRoute('listar_produtos', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('app/produto/new.html.twig', [
            'produto' => $produto,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'mostrar_produto', methods: ['GET'])]
    public function show(Produto $produto): Response
    {
        return $this->render('app/produto/show.html.twig', [
            'produto' => $produto,
        ]);
    }

    #[Route('/{id}/edit', name: 'editar_produto', methods: ['GET', 'POST'])]
    public function edit(Request $request, Produto $produto, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ProdutoType::class, $produto);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('listar_produtos', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('app/produto/edit.html.twig', [
            'produto' => $produto,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'remover_produto', methods: ['POST'])]
    public function delete(Request $request, Produto $produto, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $produto->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($produto);
            $entityManager->flush();
        }

        return $this->redirectToRoute('listar_produtos', [], Response::HTTP_SEE_OTHER);
    }
    #[Route('/{id}/adicionar', name: 'adicionar_estoque', methods: ['POST'])]
    public function adicionar(int $id, ProdutoRepository $repo): Response
    {
        $produto = $repo->find($id);
        if (!$produto) {
            $this->addFlash('danger', 'Produto não encontrado!');
            return $this->redirectToRoute('listar_produtos');
        }

        $produto->setQuantidade($produto->getQuantidade() + 1);
        $repo->salvar($produto);

        return $this->redirectToRoute('listar_produtos');
    }


    #[Route('/{id}/vender', name: 'vender_produto', methods: ['POST'])]
public function vender(int $id, ProdutoRepository $repo): Response
{
    $produto = $repo->find($id);
    if (!$produto) {
        $this->addFlash('danger', 'Produto não encontrado!');
        return $this->redirectToRoute('listar_produtos');
    }

    if ($produto->getQuantidade() > 0) {
        $produto->setQuantidade($produto->getQuantidade() - 1);
        $repo->salvar($produto);
    }

    return $this->redirectToRoute('listar_produtos');
}

}
