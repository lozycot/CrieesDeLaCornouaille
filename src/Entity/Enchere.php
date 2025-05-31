<?php

namespace App\Entity;

use App\Repository\EnchereRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EnchereRepository::class)]
class Enchere
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'encheres')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Acheteur $Acheteur = null;

    #[ORM\ManyToOne(inversedBy: 'encheres')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Lot $lot = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 17, scale: 2, nullable: true)]
    private ?string $prixEnchere = null;

    #[ORM\Column(type: Types::TIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $heureEnchere = null;

    #[ORM\ManyToOne(inversedBy: 'encheres')]
    private ?Facture $facture = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAcheteur(): ?Acheteur
    {
        return $this->Acheteur;
    }

    public function setAcheteur(?Acheteur $Acheteur): static
    {
        $this->Acheteur = $Acheteur;

        return $this;
    }

    public function getLot(): ?Lot
    {
        return $this->lot;
    }

    public function setLot(?Lot $lot): static
    {
        $this->lot = $lot;

        return $this;
    }

    public function getPrixEnchere(): ?string
    {
        return $this->prixEnchere;
    }

    public function setPrixEnchere(?string $prixEnchere): static
    {
        $this->prixEnchere = $prixEnchere;

        return $this;
    }

    public function getHeureEnchere(): ?\DateTimeInterface
    {
        return $this->heureEnchere;
    }

    public function setHeureEnchere(?\DateTimeInterface $heureEnchere): static
    {
        $this->heureEnchere = $heureEnchere;

        return $this;
    }

    public function getFacture(): ?Facture
    {
        return $this->facture;
    }

    public function setFacture(?Facture $facture): static
    {
        $this->facture = $facture;

        return $this;
    }

}
