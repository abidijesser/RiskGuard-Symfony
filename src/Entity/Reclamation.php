<?php

namespace App\Entity;

use App\Repository\ReclamationRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ReclamationRepository::class)]
class Reclamation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id_reclamation = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Le nom du client ne peut pas être vide")]
    #[Assert\Regex(pattern: "/^[^\d]+$/", message: "Le nom ne peut pas contenir de chiffres")]
    private ?string $nom_client = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "L'email du client ne peut pas être vide")]
    #[Assert\Email(message: "L'email '{{ value }}' n'est pas valide.")]
    private ?string $email_client = null;

    #[ORM\Column(length: 800)]
    #[Assert\NotBlank(message: "La description ne peut pas être vide")]
    #[Assert\Length(min: 10, max: 800, minMessage: "La description doit avoir au moins {{ limit }} caractères", maxMessage: "La description ne peut pas dépasser {{ limit }} caractères")]

    private ?string $description = null;

    #[ORM\Column(length: 20, nullable: true)]
    #[Assert\NotBlank(message: "Le numéro de téléphone ne peut pas être vide")]
    private ?string $num_tel = null;

    #[ORM\Column(length: 255)]
    private ?string $etat = null;

    public function getEtat(): ?string
    {
        return $this->etat;
    }

    public function setEtat(?string $etat): void
    {
        $this->etat = $etat;
    }


    public function getIdReclamation(): ?int
    {
        return $this->id_reclamation;
    }

    public function setIdReclamation(int $id_reclamation): static
    {
        $this->id_reclamation = $id_reclamation;

        return $this;
    }

    public function getNomClient(): ?string
    {
        return $this->nom_client;
    }

    public function setNomClient(string $nom_client): static
    {
        $this->nom_client = $nom_client;

        return $this;
    }

    public function getEmailClient(): ?string
    {
        return $this->email_client;
    }

    public function setEmailClient(string $email_client): static
    {
        $this->email_client = $email_client;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getNumTel(): ?string
    {
        return $this->num_tel;
    }

    public function setNumTel(?string $num_tel): static
    {
        $this->num_tel = $num_tel;

        return $this;
    }

}