<?php

namespace App\Entity;

use App\Repository\AssuranceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: AssuranceRepository::class)]
class Assurance
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'nom cannot be blank')]
    #[Assert\Regex(
        pattern: '/^\D*$/',
        message: 'Description cannot contain numbers'
    )]
    private ?string $nomdupack = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'promotiondupack cannot be blank')]
    #[Assert\Regex(
        pattern: '/^\D*$/',
        message: 'Description cannot contain numbers'
    )]
    private ?string $promotiondupack = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'description cannot be blank')]
    #[Assert\Regex(
        pattern: '/^\D*$/',
        message: 'Description cannot contain numbers'
    )]
    private ?string $description = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'typedupack cannot be blank')]
    #[Assert\Regex(
        pattern: '/^\D*$/',
        message: 'Description cannot contain numbers'
    )]
    private ?string $typedupack = null;

    #[ORM\OneToMany(targetEntity: Assurancevie::class, mappedBy: 'assurance')]
    private Collection $assurancevie;

    #[ORM\OneToMany(targetEntity: Assurancevehicule::class, mappedBy: 'assurance')]
    private Collection $assurancevehicule;

    public function __construct()
    {
        $this->assurancevie = new ArrayCollection();
        $this->assurancevehicule = new ArrayCollection();
    }
    public function __toString(): string
    {
        return $this->nomdupack;
    }
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomdupack(): ?string
    {
        return $this->nomdupack;
    }

    public function setNomdupack(string $nomdupack): static
    {
        $this->nomdupack = $nomdupack;

        return $this;
    }

    public function getPromotiondupack(): ?string
    {
        return $this->promotiondupack;
    }

    public function setPromotiondupack(string $promotiondupack): static
    {
        $this->promotiondupack = $promotiondupack;

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

    public function getTypedupack(): ?string
    {
        return $this->typedupack;
    }

    public function setTypedupack(string $typedupack): static
    {
        $this->typedupack = $typedupack;

        return $this;
    }

    /**
     * @return Collection<int, Assurancevie>
     */
    public function getAssurancevie(): Collection
    {
        return $this->assurancevie;
    }

    public function addAssurancevie(Assurancevie $assurancevie): static
    {
        if (!$this->assurancevie->contains($assurancevie)) {
            $this->assurancevie->add($assurancevie);
            $assurancevie->setAssurance($this);
        }

        return $this;
    }

    public function removeAssurancevie(Assurancevie $assurancevie): static
    {
        if ($this->assurancevie->removeElement($assurancevie)) {
            // set the owning side to null (unless already changed)
            if ($assurancevie->getAssurance() === $this) {
                $assurancevie->setAssurance(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Assurancevehicule>
     */
    public function getAssurancevehicule(): Collection
    {
        return $this->assurancevehicule;
    }

    public function addAssurancevehicule(Assurancevehicule $assurancevehicule): static
    {
        if (!$this->assurancevehicule->contains($assurancevehicule)) {
            $this->assurancevehicule->add($assurancevehicule);
            $assurancevehicule->setAssurance($this);
        }

        return $this;
    }

    public function removeAssurancevehicule(Assurancevehicule $assurancevehicule): static
    {
        if ($this->assurancevehicule->removeElement($assurancevehicule)) {
            // set the owning side to null (unless already changed)
            if ($assurancevehicule->getAssurance() === $this) {
                $assurancevehicule->setAssurance(null);
            }
        }

        return $this;
    }
}
