<?php

namespace App\Entity;

use App\Repository\TypeInvitationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TypeInvitationRepository::class)
 */
class TypeInvitation
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
    private $libtypeinvitation;

    /**
     * @ORM\OneToMany(targetEntity=Invitations::class, mappedBy="typeinvitation")
     */
    private $invitations;

    public function __construct()
    {
        $this->invitations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibtypeinvitation(): ?string
    {
        return $this->libtypeinvitation;
    }

    public function setLibtypeinvitation(string $libtypeinvitation): self
    {
        $this->libtypeinvitation = $libtypeinvitation;

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
            $invitation->setTypeinvitation($this);
        }

        return $this;
    }

    public function removeInvitation(Invitations $invitation): self
    {
        if ($this->invitations->removeElement($invitation)) {
            // set the owning side to null (unless already changed)
            if ($invitation->getTypeinvitation() === $this) {
                $invitation->setTypeinvitation(null);
            }
        }

        return $this;
    }
}
