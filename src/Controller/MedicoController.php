<?php

namespace App\Controller;

use App\Factory\MedicoFactory;
use App\Repository\MedicoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class MedicoController extends AbstractController
{
    private $entityManager;
    private $medicoRepository;
    private $medicoFactory;

    public function __construct(
        EntityManagerInterface $entityManager, 
        MedicoRepository $medicoRepository,
        MedicoFactory $medicoFactory
    )
    {
        $this->entityManager    = $entityManager;
        $this->medicoRepository = $medicoRepository;
        $this->medicoFactory    = $medicoFactory;
    }

    public function index(): Response
    {
        try {

            $dataMedico = $this->medicoRepository->findAll();

            return new JsonResponse($dataMedico, 200);

        } catch (\Throwable $th) {

            throw $th;
        }
        
    }

    public function show(int $id): Response
    {
        try {

            $dataMedico = $this->medicoRepository->find($id);

            return new JsonResponse($dataMedico, 200);

        } catch (\Throwable $th) {
            return new JsonResponse($th, Response::HTTP_NO_CONTENT);
        }
        
    }

    public function insert(Request $r): Response 
    {
        try {

            $dataReq = $r->getContent();
            
            $medico = $this->medicoFactory->factory($dataReq);

            $this->entityManager->persist($medico);
            $this->entityManager->flush();

            return new JsonResponse($medico, 201);

        } catch (\Throwable $th) {
            throw $th;
        }

    }

    public function update(int $id, Request $r): Response 
    {
        try {

            $dataReq = $r->getContent();

            $medicoEnviado = $this->medicoFactory->factory($dataReq);

            $medicoExistente = $this->medicoRepository->find($id);

            $medicoExistente->setCrm($medicoEnviado->getCrm())
                            ->setNome($medicoEnviado->getNome())
                            ->setCodRh($medicoEnviado->getCodRh())
                            ->setEspecialidade($medicoEnviado->getEspecialidade());;

            $this->entityManager->flush();

            return new JsonResponse($medicoExistente, 200);

        } catch (Exception $e) {
            return new JsonResponse($e, Response::HTTP_NOT_FOUND);
        }

    }

    public function delete(int $id): Response 
    {
        try {

            $medicoExistente = $this->medicoRepository->find($id);

            $this->entityManager->remove($medicoExistente);
            $this->entityManager->flush();

            return new JsonResponse(null, 200);

        } catch (Exception $e) {
            return new JsonResponse($e, Response::HTTP_NOT_FOUND);
        }

    }
}
