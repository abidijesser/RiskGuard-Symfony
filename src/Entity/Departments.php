<?php

namespace App\Entity;

use App\Repository\DepartmentsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: DepartmentsRepository::class)]
class Departments
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Assert\Positive]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    private ?string $local = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    #[Assert\Regex(pattern: '/^[a-zA-Z]+$/')]
    private ?string $chef_dep = null;

    #[ORM\Column]
    #[Assert\PositiveOrZero]
    private ?int $code = null;

    #[ORM\OneToMany(mappedBy: 'id_dep', targetEntity: Employee::class, cascade: ["remove"])]
    private Collection $employees;
    

    public function __construct()
    {
        $this->employees = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->getId() . ' - ' . $this->getLocal() . ' - ' . $this->getChefDep() . ' - ' . $this->getCode();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLocal(): ?string
    {
        return $this->local;
    }

    public function setLocal(string $local): static
    {
        $this->local = $local;

        return $this;
    }

    public function getChefDep(): ?string
    {
        return $this->chef_dep;
    }

    public function setChefDep(string $chef_dep): static
    {
        $this->chef_dep = $chef_dep;

        return $this;
    }

    public function getCode(): ?int
    {
        return $this->code;
    }

    public function setCode(int $code): static
    {
        $this->code = $code;

        return $this;
    }

    /**
     * @return Collection<int, Employee>
     */
    public function getEmployees(): Collection
    {
        return $this->employees;
    }

    public function addEmployee(Employee $employee): static
    {
        if (!$this->employees->contains($employee)) {
            $this->employees->add($employee);
            $employee->setIdDep($this);
        }

        return $this;
    }

    public function removeEmployee(Employee $employee): static
    {
        if ($this->employees->removeElement($employee)) {
            // set the owning side to null (unless already changed)
            if ($employee->getIdDep() === $this) {
                $employee->setIdDep(null);
            }
        }

        return $this;
    }
}
