<?php

namespace App\Entity;

use App\Repository\FacturationRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=FacturationRepository::class)
 */
class Facturation
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="idv")
     * @ORM\JoinColumn(nullable=false)
     */
    private $idu;

    /**
     * @ORM\ManyToOne(targetEntity=Voiture::class, inversedBy="facturations")
     * @ORM\JoinColumn(nullable=false)
     */
    private $idv;

    /**
     * @ORM\Column(type="date")
     */
    private $dateD;

    /**
     * @ORM\Column(type="date")
     */
    private $dateF;

    /**
     * @ORM\Column(type="float")
     */
    private $prix;

    /**
     * @ORM\Column(type="boolean")
     */
    private $paye;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdu(): ?User
    {
        return $this->idu;
    }

    public function setIdu(?User $idu): self
    {
        $this->idu = $idu;

        return $this;
    }

    public function getIdv(): ?Voiture
    {
        return $this->idv;
    }

    public function setIdv(?Voiture $idv): self
    {
        $this->idv = $idv;

        return $this;
    }

    public function getDateD(): ?\DateTimeInterface
    {
        return $this->dateD;
    }

    public function setDateD(\DateTimeInterface $dateD): self
    {
        $this->dateD = $dateD;

        return $this;
    }

    public function getDateF(): ?\DateTimeInterface
    {
        return $this->dateF;
    }

    public function setDateF(\DateTimeInterface $dateF): self
    {
        $this->dateF = $dateF;

        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function getPaye(): ?bool
    {
        return $this->paye;
    }

    public function setPaye(bool $paye): self
    {
        $this->paye = $paye;

        return $this;
    }
}
