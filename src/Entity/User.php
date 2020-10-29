<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Cocur\Slugify\Slugify;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 */
class User implements UserInterface,\Serializable
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom;

    /**
     * @ORM\Column(type="boolean")
     */
    private $admin;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $username;

    /**
     * @ORM\OneToMany(targetEntity=Facturation::class, mappedBy="idu")
     */
    private $idv;

    public function __construct()
    {
        $this->idv = new ArrayCollection();
    }



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getRoles()
    {
        if ($this->admin){
            return array('ROLE_ADMIN','ROLE_USER');
        }else return array('ROLE_USER');
    }

    public function getSalt()
    {
        return null;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function eraseCredentials()
    {}

    public function getAdmin(): ?bool
    {
        return $this->admin;
    }

    public function setAdmin(bool $admin): self
    {
        $this->admin = $admin;

        return $this;
    }

    public function getSlug() : string
    {
        return (new Slugify())->slugify($this->nom);
    }
    public function serialize()
    {
        return serialize([
            $this->id,
            $this->username,
            $this->password,
        ]);
    }

    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->username,
            $this->password,

        ) = unserialize($serialized,['allowed_classes'=> false]);
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @return Collection|Facturation[]
     */
    public function getIdv(): Collection
    {
        return $this->idv;
    }

    public function addIdv(Facturation $idv): self
    {
        if (!$this->idv->contains($idv)) {
            $this->idv[] = $idv;
            $idv->setIdu($this);
        }

        return $this;
    }

    public function removeIdv(Facturation $idv): self
    {
        if ($this->idv->contains($idv)) {
            $this->idv->removeElement($idv);
            // set the owning side to null (unless already changed)
            if ($idv->getIdu() === $this) {
                $idv->setIdu(null);
            }
        }

        return $this;
    }
    public function __toString():string
    {
        return $this->nom;
    }
}
