<?php

namespace App\Entity;

use App\Repository\LotRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LotRepository::class)]
class Lot
{
    #[ORM\Id]
    #[ORM\Column]
    #[ORM\GeneratedValue]
    private ?int $id = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 17, scale: 2, nullable: true)]
    private ?string $prixPlancher = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 17, scale: 2, nullable: true)]
    private ?string $prixDepart = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 17, scale: 2, nullable: true)]
    private ?string $prixEncheresMax = null;

    #[ORM\Column(type: Types::TIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $heureDebutEnchere = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $codeEtat = null;

    #[ORM\Column(nullable: true)]
    private ?int $poidsBrutLot = null;

    #[ORM\ManyToOne(inversedBy: 'lots')]
    private ?Qualite $qualite = null;

    #[ORM\ManyToOne(inversedBy: 'lots')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Bac $bac = null;

    #[ORM\ManyToOne(inversedBy: 'lots')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Presentation $presentation = null;

    #[ORM\ManyToOne(inversedBy: 'lots')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Taille $taille = null;

    #[ORM\ManyToOne(inversedBy: 'lots')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Espece $espece = null;

    /**
     * @var Collection<int, Enchere>
     */
    #[ORM\OneToMany(targetEntity: Enchere::class, mappedBy: 'lot', orphanRemoval: true)]
    private Collection $encheres;

    #[ORM\ManyToOne(inversedBy: 'lots')]
    private ?Peche $peche = null;

    #[ORM\ManyToOne(inversedBy: 'lots')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Vente $vente = null;


    public function __construct()
    {
        $this->encheres = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPrixPlancher(): ?string
    {
        return $this->prixPlancher;
    }

    public function setPrixPlancher(?string $prixPlancher): static
    {
        $this->prixPlancher = $prixPlancher;

        return $this;
    }

    public function getPrixDepart(): ?string
    {
        return $this->prixDepart;
    }

    public function setPrixDepart(?string $prixDepart): static
    {
        $this->prixDepart = $prixDepart;

        return $this;
    }

    public function getPrixEncheresMax(): ?string
    {
        return $this->prixEncheresMax;
    }

    public function setPrixEncheresMax(?string $prixEncheresMax): static
    {
        $this->prixEncheresMax = $prixEncheresMax;

        return $this;
    }

    public function getHeureDebutEnchere(): ?\DateTimeInterface
    {
        return $this->heureDebutEnchere;
    }

    public function setHeureDebutEnchere(?\DateTimeInterface $heureDebutEnchere): static
    {
        $this->heureDebutEnchere = $heureDebutEnchere;

        return $this;
    }

    public function getCodeEtat(): ?string
    {
        return $this->codeEtat;
    }

    public function setCodeEtat(?string $codeEtat): static
    {
        $this->codeEtat = $codeEtat;

        return $this;
    }

    public function getPoidsBrutLot(): ?int
    {
        return $this->poidsBrutLot;
    }

    public function setPoidsBrutLot(?int $poidsBrutLot): static
    {
        $this->poidsBrutLot = $poidsBrutLot;

        return $this;
    }

    public function getQualite(): ?Qualite
    {
        return $this->qualite;
    }

    public function setQualite(?Qualite $qualite): static
    {
        $this->qualite = $qualite;

        return $this;
    }

    public function getBac(): ?Bac
    {
        return $this->bac;
    }

    public function setBac(?Bac $bac): static
    {
        $this->bac = $bac;

        return $this;
    }

    public function getPresentation(): ?Presentation
    {
        return $this->presentation;
    }

    public function setPresentation(?Presentation $presentation): static
    {
        $this->presentation = $presentation;

        return $this;
    }

    public function getTaille(): ?Taille
    {
        return $this->taille;
    }

    public function setTaille(?Taille $taille): static
    {
        $this->taille = $taille;

        return $this;
    }

    public function getEspece(): ?Espece
    {
        return $this->espece;
    }

    public function setEspece(?Espece $espece): static
    {
        $this->espece = $espece;

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
            $enchere->setLot($this);
        }

        return $this;
    }

    public function removeEnchere(Enchere $enchere): static
    {
        if ($this->encheres->removeElement($enchere)) {
            // set the owning side to null (unless already changed)
            if ($enchere->getLot() === $this) {
                $enchere->setLot(null);
            }
        }

        return $this;
    }

    public function getPeche(): ?Peche
    {
        return $this->peche;
    }

    public function setPeche(?Peche $peche): static
    {
        $this->peche = $peche;

        return $this;
    }

    public function getVente(): ?Vente
    {
        return $this->vente;
    }

    public function setVente(?Vente $vente): static
    {
        $this->vente = $vente;

        return $this;
    }

}
