<?php

namespace App\Entity;

use App\Repository\SalleDeTravailRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SalleDeTravailRepository::class)]
class SalleDeTravail
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column]
    private ?int $maxCapacity = null;

    #[ORM\Column]
    private ?bool $wifi = null;

    #[ORM\Column]
    private ?bool $projector = null;

    #[ORM\Column]
    private ?bool $tableau = null;

    #[ORM\Column]
    private ?int $prisesElectric = null;

    #[ORM\Column]
    private ?bool $television = null;

    #[ORM\Column]
    private ?bool $climatisation = null;

    #[ORM\Column(length: 255)]
    private ?string $image = null;

    #[ORM\OneToMany(mappedBy: 'salle', targetEntity: Reservations::class, orphanRemoval: true)]
    private Collection $reservations;

    public function __construct()
    {
        $this->reservations = new ArrayCollection();
    }
    public function getReservations(): Collection
    {
        return $this->reservations;
    }

    public function addReservation(Reservations $reservation): self
    {
        if (!$this->reservations->contains($reservation)) {
            $this->reservations[] = $reservation;
            $reservation->setSalle($this);
        }

        return $this;    
    }

    public function removeReservation(Reservations $reservation): self
    {
        if ($this->reservations->removeElement($reservation)) {
            // set the owning side to null (unless already changed)
            if ($reservation->getSalle() === $this) {
                $reservation->setSalle(null);
            }
        }

        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getMaxCapacity(): ?int
    {
        return $this->maxCapacity;
    }

    public function setMaxCapacity(int $maxCapacity): static
    {
        $this->maxCapacity = $maxCapacity;

        return $this;
    }

    public function isWifi(): ?bool
    {
        return $this->wifi;
    }

    public function setWifi(bool $wifi): static
    {
        $this->wifi = $wifi;

        return $this;
    }

    public function isProjector(): ?bool
    {
        return $this->projector;
    }

    public function setProjector(bool $projector): static
    {
        $this->projector = $projector;

        return $this;
    }

    public function isTableau(): ?bool
    {
        return $this->tableau;
    }

    public function setTableau(bool $tableau): static
    {
        $this->tableau = $tableau;

        return $this;
    }

    public function getPrisesElectric(): ?int
    {
        return $this->prisesElectric;
    }

    public function setPrisesElectric(int $prisesElectric): static
    {
        $this->prisesElectric = $prisesElectric;

        return $this;
    }

    public function isTelevision(): ?bool
    {
        return $this->television;
    }

    public function setTelevision(bool $television): static
    {
        $this->television = $television;

        return $this;
    }

    public function isClimatisation(): ?bool
    {
        return $this->climatisation;
    }

    public function setClimatisation(bool $climatisation): static
    {
        $this->climatisation = $climatisation;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): static
    {
        $this->image = $image;


        return $this;
    }

}
