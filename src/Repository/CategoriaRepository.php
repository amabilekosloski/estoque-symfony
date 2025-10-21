<?php

namespace App\Repository;

use App\Entity\Categoria;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Categoria>
 */
class CategoriaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Categoria::class);
    }

    public function salvar(Categoria $categoria): void
    {
        $em = $this->getEntityManager(); 
        $em->persist($categoria);
        $em->flush();
    }

    public function remover(Categoria $categoria): void
    {
        $em = $this->getEntityManager();
        $em->remove($categoria);
        $em->flush();
    }
}
