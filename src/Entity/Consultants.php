<?php

namespace App\Entity;

use App\Repository\ConsultantsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ConsultantsRepository::class)
 */
class Consultants
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $prenom;

    /**
     * @ORM\Column(type="bigint", nullable=true)
     */
    private $numsecu;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $sexe;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $ddn;

    /**
     * @ORM\ManyToOne(targetEntity=Consultants::class, inversedBy="parent")
     */
    private $enfant;

    /**
     * @ORM\OneToMany(targetEntity=Consultants::class, mappedBy="enfant")
     */
    private $parent;

    /**
     * @ORM\OneToOne(targetEntity=Convocations::class, mappedBy="nti", cascade={"persist", "remove"})
     */
    private $convo;

    public function __construct()
    {
        $this->parent = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(?string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getNumsecu(): ?string
    {
        return $this->numsecu;
    }

    public function setNumsecu(?string $numsecu): self
    {
        $this->numsecu = $numsecu;

        return $this;
    }

    public function getSexe(): ?int
    {
        return $this->sexe;
    }

    public function setSexe(?int $sexe): self
    {
        $this->sexe = $sexe;

        return $this;
    }

    public function getDdn(): ?\DateTimeInterface
    {
        return $this->ddn;
    }

    public function setDdn(?\DateTimeInterface $ddn): self
    {
        $this->ddn = $ddn;

        return $this;
    }

    public function getEnfant(): ?self
    {
        return $this->enfant;
    }

    public function setEnfant(?self $enfant): self
    {
        $this->enfant = $enfant;

        return $this;
    }

    /**
     * @return Collection|self[]
     */
    public function getParent(): Collection
    {
        return $this->parent;
    }

    public function addParent(self $parent): self
    {
        if (!$this->parent->contains($parent)) {
            $this->parent[] = $parent;
            $parent->setEnfant($this);
        }

        return $this;
    }

    public function removeParent(self $parent): self
    {
        if ($this->parent->removeElement($parent)) {
            // set the owning side to null (unless already changed)
            if ($parent->getEnfant() === $this) {
                $parent->setEnfant(null);
            }
        }

        return $this;
    }

    public function getConvo(): ?Convocations
    {
        return $this->convo;
    }

    public function setConvo(?Convocations $convo): self
    {
        $this->convo = $convo;

        // set (or unset) the owning side of the relation if necessary
        $newNti = null === $convo ? null : $this;
        if ($convo->getNti() !== $newNti) {
            $convo->setNti($newNti);
        }

        return $this;
    }
}
