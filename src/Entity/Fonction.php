<?php

namespace App\Entity;

use App\Repository\FonctionRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=FonctionRepository::class)
 */
class Fonction
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
    private $libfonction;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibfonction(): ?string
    {
        return $this->libfonction;
    }

    public function setLibfonction(string $libfonction): self
    {
        $this->libfonction = $libfonction;

        return $this;
    }
}
