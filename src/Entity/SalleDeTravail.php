<?php

namespace App\Entity;

use App\Repository\SalleDeTravailRepository;
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
    private ?int $max_capacity = null;

    #[ORM\Column]
    private ?bool $wifi = null;

    #[ORM\Column]
    private ?bool $projector = null;

    #[ORM\Column]
    private ?bool $tableau = null;

    #[ORM\Column]
    private ?int $prises_electric = null;

    #[ORM\Column]
    private ?bool $television = null;

    #[ORM\Column]
    private ?bool $climatisation = null;

    #[ORM\Column(length: 255)]
    private ?string $image = null;

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
        return $this->max_capacity;
    }

    public function setMaxCapacity(int $max_capacity): static
    {
        $this->max_capacity = $max_capacity;

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
        return $this->prises_electric;
    }

    public function setPrisesElectric(int $prises_electric): static
    {
        $this->prises_electric = $prises_electric;

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
