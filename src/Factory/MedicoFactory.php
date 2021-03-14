<?php

namespace App\Factory;

use App\Entity\Medico;
use App\Repository\EspecialidadeRepository;

class MedicoFactory
{
    private $especialidadeRepository;

    public function __construct(EspecialidadeRepository $especialidadeRepository)
    {
        $this->especialidadeRepository = $especialidadeRepository;
    }

    public function factory(string $json): Medico
    {
        $medico = json_decode($json);
        $especialidadeId = $medico->especialidadeId;
        $especialidade = $this->especialidadeRepository->find($especialidadeId);

        $dataMedico = new Medico;

        $dataMedico->setCrm($medico->crm)
                   ->setNome($medico->nome)
                   ->setCodRh($medico->codRH)
                   ->setEspecialidade($especialidade);

        return $dataMedico;
    }
}
