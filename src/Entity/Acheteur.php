<?php

namespace App\Entity;

use App\Repository\AcheteurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AcheteurRepository::class)]
class Acheteur
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $raisonSocialeEntreprise = null;

    #[ORM\Column(length: 5, nullable: true)]
    private ?string $numRue = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $rue = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $ville = null;

    #[ORM\Column(length: 5, nullable: true)]
    private ?string $codePostal = null;

    #[ORM\Column(length: 10)]
    private ?string $numHabilitation = null;

    /**
     * @var Collection<int, Lot>
     */
    #[ORM\OneToMany(targetEntity: Lot::class, mappedBy: 'acheteur')]
    private Collection $lots;

    /**
     * @var Collection<int, Enchere>
     */
    #[ORM\OneToMany(targetEntity: Enchere::class, mappedBy: 'Acheteur', orphanRemoval: true)]
    private Collection $encheres;

    #[ORM\ManyToOne(inversedBy: 'acheteurs')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    public function __construct()
    {
        $this->encheres = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRaisonSocialeEntreprise(): ?string
    {
        return $this->raisonSocialeEntreprise;
    }

    public function setRaisonSocialeEntreprise(?string $raisonSocialeEntreprise): static
    {
        $this->raisonSocialeEntreprise = $raisonSocialeEntreprise;

        return $this;
    }

    public function getNumRue(): ?string
    {
        return $this->numRue;
    }

    public function setNumRue(?string $numRue): static
    {
        $this->numRue = $numRue;

        return $this;
    }

    public function getRue(): ?string
    {
        return $this->rue;
    }

    public function setRue(?string $rue): static
    {
        $this->rue = $rue;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(?string $ville): static
    {
        $this->ville = $ville;

        return $this;
    }

    public function getCodePostal(): ?string
    {
        return $this->codePostal;
    }

    public function setCodePostal(?string $codePostal): static
    {
        $this->codePostal = $codePostal;

        return $this;
    }

    public function getNumHabilitation(): ?string
    {
        return $this->numHabilitation;
    }

    public function setNumHabilitation(string $numHabilitation): static
    {
        $this->numHabilitation = $numHabilitation;

        return $this;
    }

    /**
     * @return Collection<int, Lot>
     */
    public function getLots(): Collection
    {
        return $this->lots;
    }

    public function addLot(Lot $lot): static
    {
        if (!$this->lots->contains($lot)) {
            $this->lots->add($lot);
            $lot->setAcheteur($this);
        }

        return $this;
    }

    public function removeLot(Lot $lot): static
    {
        if ($this->lots->removeElement($lot)) {
            // set the owning side to null (unless already changed)
            if ($lot->getAcheteur() === $this) {
                $lot->setAcheteur(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Enchere>
     */
    public function getEncheres(): Collection
    {
        return $this->encheres;
    }

    public function addEnchere(Enchere $enchere): static
    {
        if (!$this->encheres->contains($enchere)) {
            $this->encheres->add($enchere);
            $enchere->setAcheteur($this);
        }

        return $this;
    }

    public function removeEnchere(Enchere $enchere): static
    {
        if ($this->encheres->removeElement($enchere)) {
            // set the owning side to null (unless already changed)
            if ($enchere->getAcheteur() === $this) {
                $enchere->setAcheteur(null);
            }
        }

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

}
