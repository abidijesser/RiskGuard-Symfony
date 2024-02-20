<?php

namespace App\Entity;

use App\Repository\ClientRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ClientRepository::class)]
class Client extends AbstractUtilisateur
{

    #[ORM\Column(length: 8)]
    private ?string $cin = null;

    #[ORM\Column(length: 255)]
    public ?string $adresse_domicile = null;

    public function getCin(): ?string
    {
        return $this->cin;
    }

    public function setCin(string $cin): static
    {
        $this->cin = $cin;

        return $this;
    }

    public function getAdresseDomicile(): ?string
    {
        return $this->adresse_domicile;
    }

    public function setAdresseDomicile(string $adresse_domicile): static
    {
        $this->adresse_domicile = $adresse_domicile;

        return $this;
    }
}
