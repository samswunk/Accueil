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
     * @ORM\ManyToMany(targetEntity=Invitations::class, mappedBy="nti")
     */
    private $invitations;

    /**
     * @ORM\ManyToOne(targetEntity=Convocations::class, inversedBy="nti")
     */
    private $convocations;

    // /**
    //  * @ORM\ManyToMany(targetEntity=Consultants::class, inversedBy="enfants")
    //  */
    // private $parents;

    /**
     * @ORM\ManyToMany(targetEntity=Consultants::class, mappedBy="parents", orphanRemoval=true)
     */
    private $enfants;

    /**
     * Many Users have many Users.
     * @ORM\ManyToMany(targetEntity=Consultants::class, inversedBy="enfants", cascade={"persist"}, orphanRemoval=true)
     * @ORM\JoinTable(name="consultants_consultants",
     *      joinColumns={@ORM\JoinColumn(name="consultants_source", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="consultants_target", referencedColumnName="id")}
     *      )
     */
    private $parents;

    public function __construct()
    {
        $this->invitations = new ArrayCollection();
        $this->parents = new ArrayCollection();
        $this->enfants = new ArrayCollection();
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
     * @return Collection|Invitations[]
     */
    public function getInvitations(): Collection
    {
        return $this->invitations;
    }

    public function addInvitation(Invitations $invitation): self
    {
        if (!$this->invitations->contains($invitation)) {
            $this->invitations[] = $invitation;
            $invitation->addNti($this);
        }

        return $this;
    }

    public function removeInvitation(Invitations $invitation): self
    {
        if ($this->invitations->removeElement($invitation)) {
            $invitation->removeNti($this);
        }

        return $this;
    }

    public function getConvocations(): ?Convocations
    {
        return $this->convocations;
    }

    public function setConvocations(?Convocations $convocations): self
    {
        $this->convocations = $convocations;

        return $this;
    }

    /**
     * @return Collection|self[]
     */
    public function getParents(): Collection
    {
        return $this->parents;
    }

    public function addParent(self $parent): self
    {
        if (!$this->parents->contains($parent)) {
            $this->parents[] = $parent;
        }

        return $this;
    }

    public function removeParent(self $parent): self
    {
        $this->parents->removeElement($parent);

        return $this;
    }

    /**
     * @return Collection|self[]
     */
    public function getEnfants(): Collection
    {
        return $this->enfants;
    }

    public function addEnfant(self $enfant): self
    {
        if (!$this->enfants->contains($enfant)) {
            $this->enfants[] = $enfant;
            $enfant->addParent($this);
        }

        return $this;
    }

    public function removeEnfant(self $enfant): self
    {
        if ($this->enfants->removeElement($enfant)) {
            $enfant->removeParent($this);
        }

        return $this;
    }

}
