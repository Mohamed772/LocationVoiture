<?php

namespace App\Entity;

use Cocur\Slugify\Slugify;
use App\Repository\VoitureRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=VoitureRepository::class)
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
    private $location;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $photo;

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

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(string $location): self
    {
        $this->location = $location;

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
}
