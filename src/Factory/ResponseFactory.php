<?php

namespace App\Factory;

use phpDocumentor\Reflection\Types\Boolean;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ResponseFactory
{
    private $success;
    private $dataResponse;
    private $page;
    private $numItens;

    public function __construct(
        bool $success,
        $dataResponse,
        int $page = null,
        int $numItens = null

    ) {
        $this->success      = $success;
        $this->dataResponse = $dataResponse;
        $this->page         = $page;
        $this->numItens     = $numItens;
    }

    public function response($codeResponse = Response::HTTP_OK){

        $arrayResponse = [
            'success'       => $this->success,
            'dataResponse'  => $this->dataResponse,
        ];

        if (!is_null($this->page)) {
            $arrayResponse['page'] = $this->page;
        }
        if (!is_null($this->numItens)) {
            $arrayResponse['numItens'] = $this->numItens;
        }
        
        
        return new JsonResponse($arrayResponse, $codeResponse);

    }
}
