<?php

namespace App\Entity;

use App\Repository\CategorieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategorieRepository::class)]
class Categorie
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\OneToMany(mappedBy: 'categorie', targetEntity: Marketing::class, cascade: ['remove', 'persist'])]
    private Collection $marketing;

    public function __construct()
    {
        $this->marketing = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, Marketing>
     */
    public function getMarketing(): Collection
    {
        return $this->marketing;
    }

    public function addMarketing(Marketing $marketing): static
    {
        if (!$this->marketing->contains($marketing)) {
            $this->marketing->add($marketing);
            $marketing->setCategorie($this);
        }

        return $this;
    }

    public function removeMarketing(Marketing $marketing): static
    {
        if ($this->marketing->removeElement($marketing)) {
            // set the owning side to null (unless already changed)
            if ($marketing->getCategorie() === $this) {
                $marketing->setCategorie(null);
            }
        }

        return $this;
    }
}
