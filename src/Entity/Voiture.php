<?php

namespace App\Entity;

use Cocur\Slugify\Slugify;
use App\Repository\VoitureRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\VoitureRepository", repositoryClass=VoitureRepository::class)
 */
class Voiture
{
    const MOTEUR=[
        0=> 'Thermique',
        1=> 'Electrique',
        2=> 'Hybride'
    ];
    const VITESSE=[
        0=> 'Manuelle',
        1=> 'Automatique'
    ];



    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Assert\Length(min=3,max=250)
     * @ORM\Column(type="string", length=255)
     */
    private $intitule;

    /**
     * @ORM\Column(type="integer")
     */
    private $moteur;

    /**
     * @ORM\Column(type="integer")
     */
    private $vitesse;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $etat;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $photo;

    /**
     * @ORM\Column(type="boolean")
     */
    private $disponible;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $constructeur;

    /**
     * @ORM\OneToMany(targetEntity=Facturation::class, mappedBy="idv")
     */
    private $facturations;

    public function __construct()
    {
        $this->facturations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIntitule(): ?string
    {
        return $this->intitule;
    }

    public function setIntitule(string $intitule): self
    {
        $this->intitule = $intitule;

        return $this;
    }

    public function getSlug() : string
    {
        return (new Slugify())->slugify($this->intitule);
    }

    public function getMoteur(): ?int
    {
        return $this->moteur;
    }

    public function setMoteur(int $moteur): self
    {
        $this->moteur = $moteur;

        return $this;
    }

    public function getMoteurType(): string
    {
        return self::MOTEUR[$this->moteur];
    }

    public function getVitesse(): ?int
    {
        return $this->vitesse;
    }

    public function setVitesse(int $vitesse): self
    {
        $this->vitesse = $vitesse;

        return $this;
    }

    public function getVitesseType(): string
    {
    return self::VITESSE[$this->vitesse];
    }

    public function getEtat(): ?string
    {
        return $this->etat;
    }

    public function setEtat(string $etat): self
    {
        $this->etat = $etat;

        return $this;
    }

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(string $photo): self
    {
        $this->photo = $photo;

        return $this;
    }

    public function getDisponible(): ?bool
    {
        return $this->disponible;
    }

    public function setDisponible(bool $disponible): self
    {
        $this->disponible = $disponible;

        return $this;
    }
    public function toStringDisponible(): string
    {
        if ($this->disponible)
        {return 'Disponible';}
        else return 'Indisponible';

    }

    public function getConstructeur(): ?string
    {
        return $this->constructeur;
    }

    public function setConstructeur(string $constructeur): self
    {
        $this->constructeur = $constructeur;

        return $this;
    }

    /**
     * @return Collection|Facturation[]
     */
    public function getFacturations(): Collection
    {
        return $this->facturations;
    }

    public function addFacturation(Facturation $facturation): self
    {
        if (!$this->facturations->contains($facturation)) {
            $this->facturations[] = $facturation;
            $facturation->setIdv($this);
        }

        return $this;
    }

    public function removeFacturation(Facturation $facturation): self
    {
        if ($this->facturations->contains($facturation)) {
            $this->facturations->removeElement($facturation);
            // set the owning side to null (unless already changed)
            if ($facturation->getIdv() === $this) {
                $facturation->setIdv(null);
            }
        }

        return $this;
    }
    public function __toString():string
    {
        return $this->intitule;
    }



}
