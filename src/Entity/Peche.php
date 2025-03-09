<?php

namespace App\Entity;

use App\Repository\PecheRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PecheRepository::class)]
class Peche
{

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'peches')]
    #[ORM\JoinColumn(name: 'Peche', referencedColumnName:'id', nullable: false)]
    private ?Bateau $bateau = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $datePeche = null;

    #[ORM\Column(nullable: true)]
    private ?int $dureeMaree = null;

    /**
     * @var Collection<int, Lot>
     */
    #[ORM\OneToMany(targetEntity: Lot::class, mappedBy: 'peche')]
    private Collection $lots;


    public function __construct(
        ?Bateau $leBateau,
        ?\DateTimeInterface $laDatePeche,
    ) {
        $this->bateau = $leBateau;
        $this->datePeche = $laDatePeche;
        $this->lots = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getBateau(): ?Bateau
    {
        return $this->bateau;
    }

    public function setBateau(?Bateau $bateau): static
    {
        $this->bateau = $bateau;

        return $this;
    }

    public function getDatePeche(): ?\DateTimeInterface
    {
        return $this->datePeche;
    }

    public function setDatePeche(\DateTimeInterface $datePeche): static
    {
        $this->datePeche = $datePeche;

        return $this;
    }

    public function getDureeMaree(): ?int
    {
        return $this->dureeMaree;
    }

    public function setDureeMaree(?int $dureeMaree): static
    {
        $this->dureeMaree = $dureeMaree;

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
            $lot->setPeche($this);
        }

        return $this;
    }

    public function removeLot(Lot $lot): static
    {
        if ($this->lots->removeElement($lot)) {
            // set the owning side to null (unless already changed)
            if ($lot->getPeche() === $this) {
                $lot->setPeche(null);
            }
        }

        return $this;
    }
}
