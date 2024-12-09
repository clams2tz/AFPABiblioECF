<?php

namespace App\Entity;

use App\Repository\LoansRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LoansRepository::class)]
class Loans
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE)]
    private ?\DateTimeImmutable $borrow_date = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $due_date = null;

    #[ORM\Column]
    private ?bool $extension = null;

    #[ORM\Column]
    private ?bool $returned = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Users $user = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?books $book = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBorrowDate(): ?\DateTimeImmutable
    {
        return $this->borrow_date;
    }

    public function setBorrowDate(\DateTimeImmutable $borrow_date): static
    {
        $this->borrow_date = $borrow_date;

        return $this;
    }

    public function getDueDate(): ?\DateTimeInterface
    {
        return $this->due_date;
    }

    public function setDueDate(\DateTimeInterface $due_date): static
    {
        $this->due_date = $due_date;

        return $this;
    }

    public function isExtension(): ?bool
    {
        return $this->extension;
    }

    public function setExtension(bool $extension): static
    {
        $this->extension = $extension;

        return $this;
    }

    public function isReturned(): ?bool
    {
        return $this->returned;
    }

    public function setReturned(bool $returned): static
    {
        $this->returned = $returned;

        return $this;
    }

    public function getUser(): ?Users
    {
        return $this->user;
    }

    public function setUser(?Users $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getBook(): ?books
    {
        return $this->book;
    }

    public function setBook(?books $book): static
    {
        $this->book = $book;

        return $this;
    }

}
