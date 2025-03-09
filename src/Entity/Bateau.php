<?php

namespace App\Entity;

use App\Repository\BateauRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BateauRepository::class)]
class Bateau
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    private ?int $tailleBateau = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $nomBateau = null;

    #[ORM\ManyToOne(inversedBy: 'bateaux')]
    #[ORM\JoinColumn(nullable: false)]
    private ?TypeBateau $typeBateau = null;

    /**
     * @var Collection<int, Peche>
     */
    #[ORM\OneToMany(targetEntity: Peche::class, mappedBy: 'bateau', orphanRemoval: true)]
    private Collection $peches;

    public function __construct()
    {
        $this->peches = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTailleBateau(): ?int
    {
        return $this->tailleBateau;
    }

    public function setTailleBateau(?int $tailleBateau): static
    {
        $this->tailleBateau = $tailleBateau;

        return $this;
    }

    public function getNomBateau(): ?string
    {
        return $this->nomBateau;
    }

    public function setNomBateau(?string $nomBateau): static
    {
        $this->nomBateau = $nomBateau;

        return $this;
    }

    public function getTypeBateau(): ?TypeBateau
    {
        return $this->typeBateau;
    }

    public function setTypeBateau(?TypeBateau $typeBateau): static
    {
        $this->typeBateau = $typeBateau;

        return $this;
    }

    /**
     * @return Collection<int, Peche>
     */
    public function getPeches(): Collection
    {
        return $this->peches;
    }

    public function addPech(Peche $pech): static
    {
        if (!$this->peches->contains($pech)) {
            $this->peches->add($pech);
            $pech->setBateau($this);
        }

        return $this;
    }

    public function removePech(Peche $pech): static
    {
        if ($this->peches->removeElement($pech)) {
            // set the owning side to null (unless already changed)
            if ($pech->getBateau() === $this) {
                $pech->setBateau(null);
            }
        }

        return $this;
    }
}
