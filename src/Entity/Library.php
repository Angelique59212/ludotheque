<?php

namespace App\Entity;

use App\Repository\LibraryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LibraryRepository::class)]
class Library
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $name = null;

    #[ORM\ManyToOne(inversedBy: 'library')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\ManyToOne(inversedBy: 'library')]
    private ?Category $category = null;

    #[ORM\OneToMany(mappedBy: 'library', targetEntity: ItemsCollection::class)]
    private Collection $itemsCollections;

    public function __construct()
    {
        $this->itemsCollections = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

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

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): static
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return Collection<int, ItemsCollection>
     */
    public function getItemsCollections(): Collection
    {
        return $this->itemsCollections;
    }

    /*
    * adds an item to the collection but first checks that it is not already associated
    * Return an instance to be able to reuse it by chaining it
    */
    public function addItemsCollection(ItemsCollection $itemsCollection): static
    {
        if (!$this->itemsCollections->contains($itemsCollection)) {
            $this->itemsCollections->add($itemsCollection);
            $itemsCollection->setLibrary($this);
        }

        return $this;
    }

    /*
     * function which checks that the item is present in the category if this is the case deletes
     * update the modify category
     */
    public function removeItemsCollection(ItemsCollection $itemsCollection): static
    {
        if ($this->itemsCollections->removeElement($itemsCollection)) {
            // set the owning side to null (unless already changed)
            if ($itemsCollection->getLibrary() === $this) {
                $itemsCollection->setLibrary(null);
            }
        }

        return $this;
    }

    public function __toString() {
        return $this->name;
    }
}
