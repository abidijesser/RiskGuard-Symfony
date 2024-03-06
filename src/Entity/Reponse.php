<?php

namespace App\Entity;

use App\Entity\Reclamation;
use App\Repository\ReponseRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use phpDocumentor\Reflection\Types\Integer;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;



#[ORM\Entity(repositoryClass: ReponseRepository::class)]
class Reponse
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: "id_reponse", type: "integer")]
    private ?int $id_reponse = null;

    #[ORM\ManyToOne(targetEntity: Reclamation::class)]
    #[ORM\JoinColumn(name: "id_reclamation", referencedColumnName: "id_reclamation", nullable: false)]
    private ?Reclamation $reclamation = null;

    #[ORM\Column(type: "datetime")]
    #[Assert\NotBlank(message:"La date ne doit pas être vide.")]
    #[Assert\Type("\DateTimeInterface")]
    private ?\DateTimeInterface $date = null;

    #[ORM\Column(length: 800)]
    #[Assert\NotBlank(message:"Le contenu ne doit pas être vide.")]
    #[Assert\Length(min: 8, max: 800, minMessage: "Le contenu doit avoir au moins {{ limit }} caractères", maxMessage: "Le contenu ne peut pas dépasser {{ limit }} caractères")]
    private ?string $contenu = null;

    public function getIdReponse(): ?int
    {
        return $this->id_reponse;
    }

    public function setIdReponse(int $id_reponse): self
    {
        $this->id_reponse = $id_reponse;

        return $this;
    }

    public function getReclamation(): ?Reclamation
    {
        return $this->reclamation;
    }

    public function setReclamation(?Reclamation $reclamation): self
    {
        $this->reclamation = $reclamation;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getContenu(): ?string
    {
        return $this->contenu;
    }

    public function setContenu(string $contenu): self
    {
        $this->contenu = $contenu;

        return $this;
    }

    public function getIdReclamation(): ?int
    {
        if ($this->reclamation) {
            return $this->reclamation->getIdReclamation();
        }
        return null;
    }

    public function getNomClient(): ?string
    {
        if ($this->reclamation) {
            return $this->reclamation->getNomClient();
        }
        return null;
    }
    public function getDescription(): ?string
    {
        if ($this->reclamation) {
            return $this->reclamation->getDescription();
        }
        return null;
    }
    public function getEmailClient(): ?string
    {
        if ($this->reclamation) {
            return $this->reclamation->getEmailClient();
        }
        return null;
    }

    public function getNumTel(): ?string
    {
        if ($this->reclamation) {
            return $this->reclamation->getNumTel();
        }
        return null;
    }
}