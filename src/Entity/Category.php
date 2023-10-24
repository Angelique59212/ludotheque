<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
class Category
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $type = null;

    #[ORM\OneToMany(mappedBy: 'category', targetEntity: Library::class)]
    private Collection $library;

    public function __construct()
    {
        $this->library = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return Collection<int, Library>
     */
    public function getLibrary(): Collection
    {
        return $this->library;
    }

    public function addLibrary(Library $library): static
    {
        if (!$this->library->contains($library)) {
            $this->library->add($library);
            $library->setCategory($this);
        }

        return $this;
    }

    public function removeLibrary(Library $library): static
    {
        if ($this->library->removeElement($library)) {
            // set the owning side to null (unless already changed)
            if ($library->getCategory() === $this) {
                $library->setCategory(null);
            }
        }

        return $this;
    }
}
