<?php

namespace App\Entity;

use App\Repository\AbonnementRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AbonnementRepository::class)]
class Abonnement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;


    #[ORM\Column(length: 255)]
    private ?string $IBAN = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $renewal = null;

    /**
     * @var Collection<int, Users>
     */
    #[ORM\OneToMany(targetEntity: Users::class, mappedBy: 'abonnement')]
    private Collection $user_id;

    /**
     * @var Collection<int, users>
     */
    #[ORM\OneToMany(targetEntity: users::class, mappedBy: 'user_abonnement')]
    private Collection $user;

    public function __construct()
    {
        $this->user_id = new ArrayCollection();
        $this->user = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIBAN(): ?string
    {
        return $this->IBAN;
    }

    public function setIBAN(string $IBAN): static
    {
        $this->IBAN = $IBAN;

        return $this;
    }

    public function getRenewal(): ?\DateTimeInterface
    {
        return $this->renewal;
    }

    public function setRenewal(\DateTimeInterface $renewal): static
    {
        $this->renewal = $renewal;

        return $this;
    }

    /**
     * @return Collection<int, Users>
     */
    public function getUserId(): Collection
    {
        return $this->user_id;
    }

    public function addUserId(Users $userId): static
    {
        if (!$this->user_id->contains($userId)) {
            $this->user_id->add($userId);
            $userId->setAbonnement($this);
        }

        return $this;
    }

    public function removeUserId(Users $userId): static
    {
        if ($this->user_id->removeElement($userId)) {
            // set the owning side to null (unless already changed)
            if ($userId->getAbonnement() === $this) {
                $userId->setAbonnement(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, users>
     */
    public function getUser(): Collection
    {
        return $this->user;
    }
}
