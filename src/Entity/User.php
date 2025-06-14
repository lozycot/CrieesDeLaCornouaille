<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_LOGIN', fields: ['login'])]
#[UniqueEntity(fields: ['login'], message: 'There is already an account with this login')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180)]
    private ?string $login = null;

    /**
     * @var list<string> The user roles
     */
    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(length: 50)]
    private ?string $email = null;

    // /**
    //  * @var Collection<int, Acheteur>
    //  */
    // #[ORM\OneToMany(targetEntity: Acheteur::class, mappedBy: 'user', orphanRemoval: true)]
    // private Collection $acheteurs;

    #[ORM\OneToOne(mappedBy: 'user', cascade: ['persist', 'remove'])]
    private ?Acheteur $acheteur = null;

    public function __construct()
    {
        // $this->acheteurs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLogin(): ?string
    {
        return $this->login;
    }

    public function setLogin(string $login): static
    {
        $this->login = $login;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->login;
    }

    /**
     * @see UserInterface
     *
     * @return list<string>
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * @param list<string> $roles
     */
    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): static
    {
        $this->email = $email;

        return $this;
    }

    // /**
    //  * @return Collection<int, Acheteur>
    //  */
    // public function getAcheteurs(): Collection
    // {
    //     return $this->acheteurs;
    // }

    // public function addAcheteur(Acheteur $acheteur): static
    // {
    //     if (!$this->acheteurs->contains($acheteur)) {
    //         $this->acheteurs->add($acheteur);
    //         $acheteur->setUser($this);
    //     }

    //     return $this;
    // }

    // public function removeAcheteur(Acheteur $acheteur): static
    // {
    //     if ($this->acheteurs->removeElement($acheteur)) {
    //         // set the owning side to null (unless already changed)
    //         if ($acheteur->getUser() === $this) {
    //             $acheteur->setUser(null);
    //         }
    //     }

    //     return $this;
    // }

    public function getAcheteur(): ?Acheteur
    {
        return $this->acheteur;
    }

    public function setAcheteur(Acheteur $acheteur): static
    {
        // set the owning side of the relation if necessary
        if ($acheteur->getUser() !== $this) {
            $acheteur->setUser($this);
        }

        $this->acheteur = $acheteur;

        return $this;
    }
}
