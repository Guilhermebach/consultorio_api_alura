<?php

namespace App\Controller;

use App\Entity\Especialidade;
use App\Factory\EspecialidadeFactory;
use App\Helper\ExtractorDataRequest;
use App\Repository\EspecialidadeRepository;
use Doctrine\ORM\EntityManagerInterface;

class EspecialidadeController extends BaseController
{
    public function __construct(
        EntityManagerInterface $entityManager, 
        EspecialidadeRepository $especialidadeRepository,
        EspecialidadeFactory $especialidadeFactory,
        ExtractorDataRequest $extractorDataRequest
    )
    {
        parent::__construct($especialidadeRepository, $entityManager, $especialidadeFactory, $extractorDataRequest);
    }

    /**
     * @param Especialidade $entityRequest
     * @param Especialidade $entityFound
     */

    public function updateEntity($entityRequest, $entityFound)
    {
        $entityFound->setDescricao($entityRequest->getDescricao());
    }
}
