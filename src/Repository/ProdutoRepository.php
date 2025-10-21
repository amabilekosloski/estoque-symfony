<?php

namespace App\Repository;

use App\Entity\Produto;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Produto>
 */
class ProdutoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Produto::class);
    }

    public function salvar(Produto $produto): void
    {
        $em = $this->getEntityManager();
        $em->persist($produto);
        $em->flush();
    }
    public function remover(Produto $produto): void
    {
        $em = $this->getEntityManager();
        $em->remove($produto);
        $em->flush();
    }
}