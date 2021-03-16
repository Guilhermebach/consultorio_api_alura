<?php

namespace App\Helper;

use Symfony\Component\HttpFoundation\Request;

class ExtractorDataRequest
{
    private function getDataRequest(Request $request)
    {
        $filter = $request->query->all();

        $orderBy = array_key_exists ('sort', $filter)
            ? $filter['sort']
            : null;
        unset($filter['sort']);

        $page = array_key_exists ('page', $filter)
            ? $filter['page']
            : 1;
        unset($filter['page']);

        $numItens = array_key_exists ('numItens', $filter)
            ? $filter['numItens']
            : 5;
        unset($filter['numItens']);

        return [$filter, $orderBy, $page, $numItens];
    }

    public function getOrderBy(Request $request)
    {
        [,$orderBy] = $this->getDataRequest($request);

        return $orderBy;
    }

    public function getFilter(Request $request)
    {
        [$filter,] = $this->getDataRequest($request);

        return $filter;
    }

    public function getPagination(Request $request)
    {
        [, , $page, $numItens] = $this->getDataRequest($request);

        return [$page, $numItens];
    }

}
