<?php

namespace App\Controller;

use App\Helper\ExtractorDataRequest;
use App\Interface\FactoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectRepository;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

abstract class BaseController extends AbstractController
{
    protected $repository;
    protected $factory;
    protected $entityManager;
    protected $extractorDataRequest;

    public function __construct(
        ObjectRepository $repository,
        EntityManagerInterface $entityManager,
        FactoryInterface $factory,
        ExtractorDataRequest $extractorDataRequest
    ){
        $this->repository           = $repository;
        $this->entityManager        = $entityManager;
        $this->factory              = $factory;
        $this->extractorDataRequest = $extractorDataRequest;
    }

    abstract public function updateEntity($entityRequest, $entityFound);

    public function index(Request $r): Response
    {
        try {

            $orderBy = $this->extractorDataRequest->getOrderBy($r);
            $filter = $this->extractorDataRequest->getFilter($r);

            [$page, $numItens] = $this->extractorDataRequest->getPagination($r);

            $dataEntity = $this->repository->findBy($filter, $orderBy, $numItens, ($page - 1) * $numItens);

            return new JsonResponse($dataEntity, Response::HTTP_OK);

        } catch (\Throwable $th) {

            throw $th;
        }
    }

    public function show(int $id): Response
    {
        try {

            return new JsonResponse($this->repository->find($id), Response::HTTP_OK);

        } catch (\Throwable $th) {
            return new JsonResponse($th, Response::HTTP_NO_CONTENT);
        }
        
    }

    public function insert(Request $r): Response 
    {
        try {

            $dataReq = $r->getContent();
            
            $new = $this->factory->factory($dataReq);

            $this->entityManager->persist($new);
            $this->entityManager->flush();

            return new JsonResponse($new, Response::HTTP_CREATED);

        } catch (\Throwable $th) {
            throw $th;
        }

    }

    public function update(int $id, Request $r): Response 
    {
        try {

            $dataReq = $r->getContent();

            $entityRequest = $this->factory->factory($dataReq);

            $entityFound = $this->repository->find($id);

            $this->updateEntity($entityRequest, $entityFound);

            $this->entityManager->flush();

            return new JsonResponse($entityFound, Response::HTTP_OK);

        } catch (Exception $e) {
            return new JsonResponse($e, Response::HTTP_NOT_FOUND);
        }

    }

    public function delete(int $id): Response 
    {
        try {

            $entity = $this->repository->find($id);

            $this->entityManager->remove($entity);
            $this->entityManager->flush();

            return new JsonResponse(null, Response::HTTP_NO_CONTENT);

        } catch (Exception $e) {
            return new JsonResponse($e, Response::HTTP_NOT_FOUND);
        }

    }

}
