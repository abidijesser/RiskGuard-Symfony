<?php

namespace App\Entity;

use App\Repository\ConstatvieRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
#[ORM\Entity(repositoryClass: ConstatvieRepository::class)]

class Constatvie extends Sinistre
{
  

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $DateDeDeces = null;

    #[ORM\Column(length: 255)]
    private ?string $CauseDeDeces = null;

    #[ORM\Column(length: 255)]
    private ?string $IdentifiantDeLinformant = null;

    

    

    public function getDateDeDeces(): ?\DateTimeInterface
    {
        return $this->DateDeDeces;
    }

    public function setDateDeDeces(\DateTimeInterface $DateDeDeces): static
    {
        $this->DateDeDeces = $DateDeDeces;

        return $this;
    }

    public function getCauseDeDeces(): ?string
    {
        return $this->CauseDeDeces;
    }

    public function setCauseDeDeces(string $CauseDeDeces): static
    {
        $this->CauseDeDeces = $CauseDeDeces;

        return $this;
    }

    public function getIdentifiantDeLinformant(): ?string
    {
        return $this->IdentifiantDeLinformant;
    }

    public function setIdentifiantDeLinformant(string $IdentifiantDeLinformant): static
    {
        $this->IdentifiantDeLinformant = $IdentifiantDeLinformant;

        return $this;
    }

   
}
