<?php

namespace App\Factory;

use App\Entity\Especialidade;
use App\Interface\FactoryInterface;

class EspecialidadeFactory implements FactoryInterface
{
    public function factory(string $json): Especialidade
    {
        $especialidade = json_decode($json);
        $dataespecialidade = new Especialidade;

        $dataespecialidade->setDescricao($especialidade->descricao);

        return $dataespecialidade;
    }

}
