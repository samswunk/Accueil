<?php

namespace App\Entity;

use App\Repository\InvitationsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=InvitationsRepository::class)
 */
class Invitations
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateinvitation;

    /**
     * @ORM\ManyToMany(targetEntity=Consultants::class, inversedBy="invitations")
     */
    private $nti;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $nbrpersonnes;

    /**
     * @ORM\ManyToOne(targetEntity=TypeInvitation::class, inversedBy="invitations")
     */
    private $typeinvitation;

    public function __construct()
    {
        $this->nti = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->getNti();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateinvitation(): ?\DateTimeInterface
    {
        return $this->dateinvitation;
    }

    public function setDateinvitation(\DateTimeInterface $dateinvitation): self
    {
        $this->dateinvitation = $dateinvitation;

        return $this;
    }

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
        }

        return $this;
    }

    public function removeNti(Consultants $nti): self
    {
        $this->nti->removeElement($nti);

        return $this;
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

    public function getTypeinvitation(): ?TypeInvitation
    {
        return $this->typeinvitation;
    }

    public function setTypeinvitation(?TypeInvitation $typeinvitation): self
    {
        $this->typeinvitation = $typeinvitation;

        return $this;
    }
}
