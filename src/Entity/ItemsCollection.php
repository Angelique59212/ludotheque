<?php

namespace App\Entity;

use App\Repository\ItemsCollectionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ItemsCollectionRepository::class)]
class ItemsCollection
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 70)]
    private ?string $title = null;

    #[ORM\Column(length: 50)]
    private ?string $author = null;

    #[ORM\Column(length: 50)]
    private ?string $editor = null;

    #[ORM\Column(nullable: true)]
    private ?int $number_player = null;

    #[ORM\Column(nullable: true)]
    private ?int $playing_time = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $language = null;

    #[ORM\OneToMany(mappedBy: 'item�s_collectio', targetEntity: Borrow::class)]
    private Collection $borrows;

    #[ORM\ManyToOne(inversedBy: 'items_collection')]
    private ?Category $category = null;

    #[ORM\ManyToOne(inversedBy: 'itemsCollections')]
    private ?Library $library = null;

    #[ORM\OneToMany(mappedBy: 'itemsCollection', targetEntity: Image::class)]
    private Collection $image;

    #[ORM\ManyToOne(inversedBy: 'item')]
    private ?User $user = null;

    public function __construct()
    {
        $this->borrows = new ArrayCollection();
        $this->image = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getAuthor(): ?string
    {
        return $this->author;
    }

    public function setAuthor(string $author): static
    {
        $this->author = $author;

        return $this;
    }

    public function getEditor(): ?string
    {
        return $this->editor;
    }

    public function setEditor(string $editor): static
    {
        $this->editor = $editor;

        return $this;
    }

    public function getNumberPlayer(): ?int
    {
        return $this->number_player;
    }

    public function setNumberPlayer(?int $number_player): static
    {
        $this->number_player = $number_player;

        return $this;
    }

    public function getPlayingTime(): ?int
    {
        return $this->playing_time;
    }

    public function setPlayingTime(?int $playing_time): static
    {
        $this->playing_time = $playing_time;

        return $this;
    }

    public function getLanguage(): ?string
    {
        return $this->language;
    }

    public function setLanguage(?string $language): static
    {
        $this->language = $language;

        return $this;
    }

    /**
     * @return Library<int, Borrow>
     */
    public function getBorrows(): Collection
    {
        return $this->borrows;
    }

    public function addBorrow(Borrow $borrow): static
    {
        if (!$this->borrows->contains($borrow)) {
            $this->borrows->add($borrow);
            $borrow->setItemsCollection($this);
        }

        return $this;
    }

    public function removeBorrow(Borrow $borrow): static
    {
        if ($this->borrows->removeElement($borrow)) {
            // set the owning side to null (unless already changed)
            if ($borrow->getItemsCollection() === $this) {
                $borrow->setItemsCollection(null);
            }
        }

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

    public function getLibrary(): ?Library
    {
        return $this->library;
    }

    public function setLibrary(?Library $library): static
    {
        $this->library = $library;

        return $this;
    }

    /**
     * @return Collection<int, Image>
     */
    public function getImage(): Collection
    {
        return $this->image;
    }

    public function addImage(Image $image): static
    {
        if (!$this->image->contains($image)) {
            $this->image->add($image);
            $image->setItemsCollection($this);
        }

        return $this;
    }

    public function removeImage(Image $image): static
    {
        if ($this->image->removeElement($image)) {
            // set the owning side to null (unless already changed)
            if ($image->getItemsCollection() === $this) {
                $image->setItemsCollection(null);
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
