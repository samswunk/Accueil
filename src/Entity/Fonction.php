<?php

namespace App\Entity;

use App\Repository\FonctionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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
     * @ORM\Column(type="string", length=255)
     */
    private $libfonction;

    /**
     * @ORM\OneToMany(targetEntity=Medinf::class, mappedBy="fonction")
     */
    private $medinfs;

    public function __construct()
    {
        $this->medinfs = new ArrayCollection();
    }

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

    /**
     * @return Collection|Medinf[]
     */
    public function getMedinfs(): Collection
    {
        return $this->medinfs;
    }

    public function addMedinf(Medinf $medinf): self
    {
        if (!$this->medinfs->contains($medinf)) {
            $this->medinfs[] = $medinf;
            $medinf->setFonction($this);
        }

        return $this;
    }

    public function removeMedinf(Medinf $medinf): self
    {
        if ($this->medinfs->removeElement($medinf)) {
            // set the owning side to null (unless already changed)
            if ($medinf->getFonction() === $this) {
                $medinf->setFonction(null);
            }
        }

        return $this;
    }
}
