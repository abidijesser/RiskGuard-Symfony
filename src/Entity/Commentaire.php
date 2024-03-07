<?php

namespace App\Entity;

use App\Repository\CommentaireRepository;
use DateTime;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CommentaireRepository::class)]
class Commentaire
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $content = null;

    #[ORM\Column(length: 50)]
    private ?string $author = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $timeStamp = null;

    #[ORM\ManyToOne(inversedBy: 'commentaires')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Marketing $marketing = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): static
    {
        $this->content = $content;

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

    public function getTimeStamp(): ?\DateTimeInterface
    {
        return $this->timeStamp;
    }

    public function setTimeStamp(\DateTimeInterface $timeStamp): static
    {
        $this->timeStamp = $timeStamp;

        return $this;
    }

    #[ORM\PrePersist]
    public function setTimeStampp(): static
    {
        $this->timeStamp = new DateTime();

        return $this;
    }

    public function getMarketing(): ?Marketing
    {
        return $this->marketing;
    }

    public function setMarketing(?Marketing $marketing): static
    {
        $this->marketing = $marketing;

        return $this;
    }
}
