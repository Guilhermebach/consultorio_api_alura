<?php

namespace App\Controller;

use App\Factory\EspecialidadeFactory;
use App\Repository\EspecialidadeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class EspecialidadeController extends AbstractController
{
    private $entityManager;
    private $especialidadeRepository;
    private $especialidadeFactory;

    public function __construct(
        EntityManagerInterface $entityManager, 
        EspecialidadeRepository $especialidadeRepository,
        EspecialidadeFactory $especialidadeFactory
    )
    {
        $this->entityManager    = $entityManager;
        $this->especialidadeRepository = $especialidadeRepository;
        $this->especialidadeFactory    = $especialidadeFactory;
    }
    
    public function index(): Response
    {
        try {

            $dataEspecialidade = $this->especialidadeRepository->findAll();

            return new JsonResponse($dataEspecialidade, 200);

        } catch (\Throwable $th) {

            throw $th;
        }
    }

    public function insert(Request $r): Response 
    {
        try {

            $dataReq = $r->getContent();
            
            $especialidade = $this->especialidadeFactory->factory($dataReq);

            $this->entityManager->persist($especialidade);
            $this->entityManager->flush();

            return new JsonResponse($especialidade, 201);

        } catch (\Throwable $th) {
            throw $th;
        }

    }

    public function show(int $id): Response
    {
        try {

            $dataEspecialidade = $this->especialidadeRepository->find($id);

            return new JsonResponse($dataEspecialidade, 200);

        } catch (\Throwable $th) {
            return new JsonResponse($th, Response::HTTP_NO_CONTENT);
        }
        
    }

    public function update(int $id, Request $r): Response 
    {
        try {

            $dataReq = $r->getContent();

            $especialidadeEnviado = $this->especialidadeFactory->factory($dataReq);

            $especialidadeExistente = $this->especialidadeRepository->find($id);

            $especialidadeExistente->setDescricao($especialidadeEnviado->getDescricao());

            $this->entityManager->flush();

            return new JsonResponse($especialidadeExistente, 200);

        } catch (Exception $e) {
            return new JsonResponse($e, Response::HTTP_NOT_FOUND);
        }

    }

    public function delete(int $id): Response 
    {
        try {

            $especialidadeExistente = $this->especialidadeRepository->find($id);

            $this->entityManager->remove($especialidadeExistente);
            $this->entityManager->flush();

            return new JsonResponse(null, 200);

        } catch (Exception $e) {
            return new JsonResponse($e, Response::HTTP_NOT_FOUND);
        }

    }
}
