<?php

namespace App\Entity;

use App\Repository\MedicoRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MedicoRepository::class)
 */
class Medico implements \JsonSerializable
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $crm;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nome;

    /**
     * @ORM\Column(type="string", length=15, nullable=true)
     */
    private $cod_rh;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Especialidade")
     * @ORM\JoinColumn(nullable=false)
     */
    private $especialidade;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCrm(): ?int
    {
        return $this->crm;
    }

    public function setCrm(int $crm): self
    {
        $this->crm = $crm;

        return $this;
    }

    public function getNome(): ?string
    {
        return $this->nome;
    }

    public function setNome(string $nome): self
    {
        $this->nome = $nome;

        return $this;
    }

    public function getCodRh(): ?string
    {
        return $this->cod_rh;
    }

    public function setCodRh(?string $cod_rh): self
    {
        $this->cod_rh = $cod_rh;

        return $this;
    }
    
    public function getEspecialidade(): ?Especialidade
    {
        return $this->especialidade;
    }

    public function setEspecialidade(?Especialidade $especialidade): self
    {
        $this->especialidade = $especialidade;

        return $this;
    }

    public function jsonSerialize()
    {
        return [
            'id' => $this->getId(),
            'crm' => $this->getCrm(),
            'nome' => $this->getNome(),
            'codRH' => $this->getCodRh(),
            'especialidadeId' => $this->getEspecialidade()->getId(),
            '_links' => [
                [
                    'rel' => 'self',
                    'path' => '/medicos/' . $this->getId()
                ],
                [
                    'rel' => 'especialidade',
                    'path' => '/especialidade/' . $this->getEspecialidade()->getId()
                ]
            ]
        ];
    }
}
