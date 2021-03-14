<?php

namespace App\Factory;

use App\Entity\Especialidade;

class EspecialidadeFactory
{
    public function factory(string $json): Especialidade
    {
        $especialidade = json_decode($json);
        $dataespecialidade = new Especialidade;

        $dataespecialidade->setDescricao($especialidade->descricao);

        return $dataespecialidade;
    }

}
