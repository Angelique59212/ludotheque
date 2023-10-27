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
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $email = null;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Borrow::class)]
    private Collection $borrows;

    #[ORM\Column(length: 50)]
    private ?string $pseudo = null;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Library::class, orphanRemoval: true)]
    private Collection $library;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: ItemsCollection::class)]
    private Collection $item;

    public function __construct()
    {
        $this->borrows = new ArrayCollection();
        $this->library = new ArrayCollection();
        $this->item = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
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

    /**
     * @return Collection
     */
    public function getBorrows(): Collection
    {
        return $this->borrows;
    }

    public function addBorrow(Borrow $borrow): static
    {
        if (!$this->borrows->contains($borrow)) {
            $this->borrows->add($borrow);
            $borrow->setUser($this);
        }

        return $this;
    }

    public function removeBorrow(Borrow $borrow): static
    {
        if ($this->borrows->removeElement($borrow)) {
            // set the owning side to null (unless already changed)
            if ($borrow->getUser() === $this) {
                $borrow->setUser(null);
            }
        }

        return $this;
    }

    public function getPseudo(): ?string
    {
        return $this->pseudo;
    }

    public function setPseudo(string $pseudo): static
    {
        $this->pseudo = $pseudo;

        return $this;
    }

    /**
     * @return ArrayCollection|Collection
     */
    public function getLibrary(): ArrayCollection|Collection
    {
        return $this->library;
    }

    /*
     * adds a library to the l'user but first checks that it is not already associated
     * Return an instance to be able to reuse it by chaining it
     */
    public function addLibrary(Library $library): static
    {
        if (!$this->library->contains($library)) {
            $this->library->add($library);
            $library->setUser($this);
        }

        return $this;
    }

    /*
     * delete a library from the user but first check that it is present
     */
    public function removeLibrary(Library $library): static
    {
        if ($this->library->removeElement($library)) {
            // set the owning side to null (unless already changed)
            if ($library->getUser() === $this) {
                $library->setUser(null);
            }
        }

        return $this;
    }

    public function __toString() {
        return $this->email;
    }

    /**
     * @return Collection<int, ItemsCollection>
     */
    public function getItem(): Collection
    {
        return $this->item;
    }

    /*
    * adds an item to user but first checks that it is not already associated
    * Return an instance to be able to reuse it by chaining it
    */
    public function addItem(ItemsCollection $item): static
    {
        if (!$this->item->contains($item)) {
            $this->item->add($item);
            $item->setUser($this);
        }

        return $this;
    }

    /*
     * remove an item from user but first checks that it is present
     */
    public function removeItem(ItemsCollection $item): static
    {
        if ($this->item->removeElement($item)) {
            // set the owning side to null (unless already changed)
            if ($item->getUser() === $this) {
                $item->setUser(null);
            }
        }

        return $this;
    }
}
