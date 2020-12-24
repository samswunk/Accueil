<?php

namespace App\Entity;

use App\Repository\ConvocationsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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
     * @ORM\OneToMany(targetEntity=Consultants::class, mappedBy="convocations")
     */
    private $nti;

    public function __construct()
    {
        $this->nti = new ArrayCollection();
    }

    // /**
    //  * @ORM\OneToOne(targetEntity=Consultants::class, inversedBy="convo", cascade={"persist", "remove"})
    //  */
    // private $nti;

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

    // public function getNti(): ?Consultants
    // {
    //     return $this->nti;
    // }

    // public function setNti(?Consultants $nti): self
    // {
    //     $this->nti = $nti;

    //     return $this;
    // }

    /**
     * @return Collection|Consultants[]
     */
    public function getNti(): Collection
    {
        return $this->nti;
    }

    public function addNti(Consultants $nti): self
    {
        if (!$this->nti->contains($nti)) {
            $this->nti[] = $nti;
            $nti->setConvocations($this);
        }

        return $this;
    }

    public function removeNti(Consultants $nti): self
    {
        if ($this->nti->removeElement($nti)) {
            // set the owning side to null (unless already changed)
            if ($nti->getConvocations() === $this) {
                $nti->setConvocations(null);
            }
        }

        return $this;
    }
}
