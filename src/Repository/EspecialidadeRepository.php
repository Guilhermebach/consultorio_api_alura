<?php

namespace App\Repository;

use App\Entity\Especialidade;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class EspecialidadeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Especialidade::class);
    }

    // /**
    //  * @return Especialidade[] Retorna um array de Especialidades
    //  */
    // public function findAll()
    // {
    //     $especialidadesList = $this->createQueryBuilder('e')
    //                         ->orderBy('e.id', 'ASC')
    //                         ->getQuery()
    //                         ->getResult();

    //     return $especialidadesList;
    // }

    // /**
    //  * @return Especialidade Retorna uma Especialidade
    //  */
    // public function findOne($value)
    // {
    //     $especialidade = $this->createQueryBuilder('e')
    //                     ->andWhere('e.id = :val')
    //                     ->setParameter('val', $value)
    //                     ->orderBy('e.id', 'ASC')
    //                     ->getQuery()
    //                     ->getSingleResult();

    //     return $especialidade;
        
    // }
}
