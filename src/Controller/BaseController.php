<?php

namespace App\Controller;

use App\Factory\ResponseFactory;
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

            $dataResponse = new ResponseFactory(true, $dataEntity, $page, $numItens);

            return $dataResponse->response();

        } catch (\Throwable $th) {

            throw $th;
        }
    }

    public function show(int $id): Response
    {
        try {

            $dataResponse = new ResponseFactory(true, $this->repository->find($id));

            return $dataResponse->response();

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

            $dataResponse = new ResponseFactory(true, $new);

            return $dataResponse->response(Response::HTTP_CREATED);

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

            $dataResponse = new ResponseFactory(true, $entityFound);

            return $dataResponse->response();

        } catch (Exception $e) {
            $dataResponseError = new ResponseFactory(false, $e);

            return $dataResponseError->response(Response::HTTP_NOT_FOUND);
        }

    }

    public function delete(int $id): Response 
    {
        try {

            $entity = $this->repository->find($id);

            $this->entityManager->remove($entity);
            $this->entityManager->flush();

            $dataResponse = new ResponseFactory(true, $entity);

            return $dataResponse->response(Response::HTTP_NO_CONTENT);

        } catch (Exception $e) {
            $dataResponseError = new ResponseFactory(false, $e);

            return $dataResponseError->response(Response::HTTP_NOT_FOUND);
        }

    }

}
