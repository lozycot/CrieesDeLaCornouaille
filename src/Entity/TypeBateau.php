<?php

namespace App\Entity;

use App\Repository\TypeBateauRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TypeBateauRepository::class)]
class TypeBateau
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $designation = null;

    /**
     * @var Collection<int, Bateau>
     */
    #[ORM\OneToMany(targetEntity: Bateau::class, mappedBy: 'typeBateau')]
    private Collection $bateaux;

    public function __construct()
    {
        $this->bateaux = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDesignation(): ?string
    {
        return $this->designation;
    }

    public function setDesignation(?string $designation): static
    {
        $this->designation = $designation;

        return $this;
    }

    /**
     * @return Collection<int, Bateau>
     */
    public function getBateaux(): Collection
    {
        return $this->bateaux;
    }

    public function addBateaux(Bateau $bateaux): static
    {
        if (!$this->bateaux->contains($bateaux)) {
            $this->bateaux->add($bateaux);
            $bateaux->setTypeBateau($this);
        }

        return $this;
    }

    public function removeBateaux(Bateau $bateaux): static
    {
        if ($this->bateaux->removeElement($bateaux)) {
            // set the owning side to null (unless already changed)
            if ($bateaux->getTypeBateau() === $this) {
                $bateaux->setTypeBateau(null);
            }
        }

        return $this;
    }
}
