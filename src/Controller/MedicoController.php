<?php

namespace App\Controller;

use App\Entity\Medico;
use App\Factory\MedicoFactory;
use App\Factory\ResponseFactory;
use App\Helper\ExtractorDataRequest;
use App\Repository\MedicoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class MedicoController extends BaseController
{
    public function __construct(
        EntityManagerInterface $entityManager, 
        MedicoRepository $medicoRepository,
        MedicoFactory $medicoFactory,
        ExtractorDataRequest $extractorDataRequest
    )
    {
        parent::__construct($medicoRepository, $entityManager, $medicoFactory, $extractorDataRequest);
    }

    /**
     * @param Medico $entityRequest
     * @param Medico $entityFound
     */

    public function updateEntity($entityRequest, $entityFound)
    {
        $entityFound->setCrm($entityRequest->getCrm())
                    ->setNome($entityRequest->getNome())
                    ->setCodRh($entityRequest->getCodRh())
                    ->setEspecialidade($entityRequest->getEspecialidade());
    }

    public function showByEspecialidade(int $especialidadeId): Response
    {
        try {

            $dataMedico = $this->repository->findBy([
                'especialidade' => $especialidadeId
            ]);

            $dataResponse = new ResponseFactory(true, $dataMedico);

            return $dataResponse->response();

        } catch (\Throwable $th) {
            $dataResponseError = new ResponseFactory(false, $th);

            return $dataResponseError->response(Response::HTTP_NO_CONTENT);
        }
        
    }
}
