<?php

namespace App\Entity;

use App\Repository\AssurancevehiculeRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: AssurancevehiculeRepository::class)]
class Assurancevehicule
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'marque cannot be blank')]
    private ?string $marque = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'modele cannot be blank')]
    private ?string $modele = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'matricule cannot be blank')]
    private ?string $matricule = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Assert\NotBlank(message: 'datedebut cannot be blank')]
    private ?\DateTimeInterface $datedebut = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'periodedevalidation  cannot be blank')]
    private ?string $periodedevalidation = null;

    #[ORM\Column(length: 255,nullable: true)]
    #[Assert\NotNull(message: 'image cannot be blank')]
    private ?string $image = null;

    #[ORM\ManyToOne(inversedBy: 'assurancevehicule')]
    private ?Assurance $assurance = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMarque(): ?string
    {
        return $this->marque;
    }

    public function setMarque(string $marque): static
    {
        $this->marque = $marque;

        return $this;
    }

    public function getModele(): ?string
    {
        return $this->modele;
    }

    public function setModele(string $modele): static
    {
        $this->modele = $modele;

        return $this;
    }

    public function getMatricule(): ?string
    {
        return $this->matricule;
    }

    public function setMatricule(string $matricule): static
    {
        $this->matricule = $matricule;

        return $this;
    }

    public function getDatedebut(): ?\DateTimeInterface
    {
        return $this->datedebut;
    }

    public function setDatedebut(\DateTimeInterface $datedebut): static
    {
        $this->datedebut = $datedebut;

        return $this;
    }

    public function getPeriodedevalidation(): ?string
    {
        return $this->periodedevalidation;
    }

    public function setPeriodedevalidation(string $periodedevalidation): static
    {
        $this->periodedevalidation = $periodedevalidation;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): static
    {
        $this->image = $image;

        return $this;
    }

    public function getAssurance(): ?Assurance
    {
        return $this->assurance;
    }

    public function setAssurance(?Assurance $assurance): static
    {
        $this->assurance = $assurance;

        return $this;
    }
}
