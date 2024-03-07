<?php

namespace App\Entity;

use App\Repository\AssurancevieRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: AssurancevieRepository::class)]
class Assurancevie
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Assert\NotBlank(message: 'datedebut  cannot be blank')]
    private ?\DateTimeInterface $datedebut = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'periodevalidation  cannot be blank')]
    private ?string $periodevalidation = null;

    #[ORM\Column]
    #[Assert\NotBlank(message: 'salaireclient  cannot be blank')]
    #[Assert\Range(
        notInRangeMessage: 'Price must be between {{ min }} and {{ max }}',
        invalidMessage: 'Price must be a number',
        min: 500,
        max: 5000
    )]
    private ?float $salaireclient = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'fiche cannot be blank')]
    private ?string $fichedepaie = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'reponse  cannot be blank')]
    private ?string $reponse = null;

    #[ORM\ManyToOne(inversedBy: 'assurancevie')]
    private ?Assurance $assurance = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getPeriodevalidation(): ?string
    {
        return $this->periodevalidation;
    }

    public function setPeriodevalidation(string $periodevalidation): static
    {
        $this->periodevalidation = $periodevalidation;

        return $this;
    }

    public function getSalaireclient(): ?float
    {
        return $this->salaireclient;
    }

    public function setSalaireclient(float $salaireclient): static
    {
        $this->salaireclient = $salaireclient;

        return $this;
    }

    public function getFichedepaie(): ?string
    {
        return $this->fichedepaie;
    }

    public function setFichedepaie(string $fichedepaie): static
    {
        $this->fichedepaie = $fichedepaie;

        return $this;
    }

    public function getReponse(): ?string
    {
        return $this->reponse;
    }

    public function setReponse(string $reponse): static
    {
        $this->reponse = $reponse;

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
