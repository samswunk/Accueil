<?php

namespace App\Entity;

use App\Repository\MetierRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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
    private $codeprofession;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $libmetier;

    /**
     * @ORM\ManyToMany(targetEntity=Medinf::class, mappedBy="metier")
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

    public function getCodeprofession(): ?string
    {
        return $this->codeprofession;
    }

    public function setCodeprofession(string $codeprofession): self
    {
        $this->codeprofession = $codeprofession;

        return $this;
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
            $medinf->addMetier($this);
        }

        return $this;
    }

    public function removeMedinf(Medinf $medinf): self
    {
        if ($this->medinfs->removeElement($medinf)) {
            $medinf->removeMetier($this);
        }

        return $this;
    }
}
