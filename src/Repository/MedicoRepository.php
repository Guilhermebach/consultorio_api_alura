<?php

namespace App\Repository;

use App\Entity\Medico;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Exception;

class MedicoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Medico::class);
    }

    // /**
    //  * @return Medico[] Retorna um array de Medicos
    //  */
    // public function findAll()
    // {
    //     $medicosList = $this->createQueryBuilder('m')
    //                         ->orderBy('m.id', 'ASC')
    //                         ->getQuery()
    //                         ->getResult();

    //     return $medicosList;
    // }

    // /**
    //  * @return Medico Retorna um medico
    //  */
    // public function findOne($value)
    // {
    //     $medico = $this->createQueryBuilder('m')
    //                     ->andWhere('m.id = :val')
    //                     ->setParameter('val', $value)
    //                     ->orderBy('m.id', 'ASC')
    //                     ->getQuery()
    //                     ->getSingleResult();

    //     return $medico;
        
    // }
}
