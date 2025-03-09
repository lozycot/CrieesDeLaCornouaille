<?php

namespace App\Entity;

use App\Repository\BateauRepository;
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
    private ?TypeBateau $idTypeBateau = null;

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

    public function getIdTypeBateau(): ?TypeBateau
    {
        return $this->idTypeBateau;
    }

    public function setIdTypeBateau(?TypeBateau $idTypeBateau): static
    {
        $this->idTypeBateau = $idTypeBateau;

        return $this;
    }
}
