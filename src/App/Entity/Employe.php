<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Employe
 *
 * @ORM\Table(name="employe")
 * @ORM\Entity(repositoryClass="App\Repository\EmployeRepository")
 */
class Employe
{
    /**
     * @var string
     *
     * @ORM\Column(name="id_emp", type="string", nullable=false, unique=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id_emp;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255, nullable=false, unique=false)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, nullable=false, unique=false)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="id_dep", type="string", nullable=false, unique=false)
     */
    private $id_dep;


}
