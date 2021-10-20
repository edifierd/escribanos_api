<?php

namespace App\Entity;

use App\Repository\EstampilladoRepository;
use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity(repositoryClass=EstampilladoRepository::class)
 */
class Estampillado
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     */
    private $estatuto;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private $num_expediente;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private $hash;

    /**
     * @ORM\Column(type="text")
     */
    private $qr;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEstatuto(): ?string
    {
        return $this->estatuto;
    }

    public function setEstatuto(string $estatuto): self
    {
        $this->estatuto = $estatuto;

        return $this;
    }

    public function getNumExpediente(): ?string
    {
        return $this->num_expediente;
    }

    public function setNumExpediente(string $num_expediente): self
    {
        $this->num_expediente = $num_expediente;

        return $this;
    }

    public function getHash(): ?string
    {
        return $this->hash;
    }

    public function setHash(string $hash): self
    {
        $this->hash = $hash;

        return $this;
    }

    public function getQr(): ?string
    {
        return $this->qr;
    }

    public function setQr(string $qr): self
    {
        $this->qr = $qr;

        return $this;
    }
}
