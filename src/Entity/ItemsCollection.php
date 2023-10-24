<?php

namespace App\Entity;

use App\Repository\ItemsCollectionRepository;
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
}
