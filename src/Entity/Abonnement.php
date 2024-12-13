<?php

namespace App\Entity;

use App\Repository\AbonnementRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AbonnementRepository::class)]
class Abonnement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $IBAN = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $renewal = null;

    #[ORM\Column(length: 255)]
    private ?string $subscription_type = null;

    #[ORM\Column]
    private ?float $price = null;

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
    
    public function getSubscriptionType(): ?string
    {
        return $this->subscription_type;
    }

    public function setSubscriptionType(string $subscription_type): static
    {
        $this->subscription_type = $subscription_type;
        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): static
    {
        $this->price = $price;

        return $this;
    }
}
