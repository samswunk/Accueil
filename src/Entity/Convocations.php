<?php

namespace App\Entity;

use App\Repository\ConvocationsRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ConvocationsRepository::class)
 */
class Convocations
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $nbrpersonnes;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateconvocation;

    /**
     * @ORM\OneToOne(targetEntity=Consultants::class, inversedBy="convo", cascade={"persist", "remove"})
     */
    private $nti;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNbrpersonnes(): ?int
    {
        return $this->nbrpersonnes;
    }

    public function setNbrpersonnes(?int $nbrpersonnes): self
    {
        $this->nbrpersonnes = $nbrpersonnes;

        return $this;
    }

    public function getDateconvocation(): ?\DateTimeInterface
    {
        return $this->dateconvocation;
    }

    public function setDateconvocation(\DateTimeInterface $dateconvocation): self
    {
        $this->dateconvocation = $dateconvocation;

        return $this;
    }

    public function getNti(): ?Consultants
    {
        return $this->nti;
    }

    public function setNti(?Consultants $nti): self
    {
        $this->nti = $nti;

        return $this;
    }
}
