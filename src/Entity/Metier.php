<?php

namespace App\Entity;

use App\Repository\MetierRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MetierRepository::class)
 */
class Metier
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $libmetier;

    /**
     * @ORM\Column(type="string", length=10)
     */
    private $codeprofession;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibmetier(): ?string
    {
        return $this->libmetier;
    }

    public function setLibmetier(string $libmetier): self
    {
        $this->libmetier = $libmetier;

        return $this;
    }

    public function getCodeprofession(): ?string
    {
        return $this->codeprofession;
    }

    public function setCodeprofession(string $codeprofession): self
    {
        $this->codeprofession = $codeprofession;

        return $this;
    }
}
