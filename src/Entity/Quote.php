<?php

namespace App\Entity;

use App\Repository\QuoteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: QuoteRepository::class)]
class Quote
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $sentence = null;

    #[ORM\Column(length: 255)]
    private ?string $personnage = null;

    #[ORM\ManyToMany(targetEntity: User::class, inversedBy: 'quotes')]
    private Collection $ofUser;

    public function __construct()
    {
        $this->ofUser = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSentence(): ?string
    {
        return $this->sentence;
    }

    public function setSentence(string $sentence): static
    {
        $this->sentence = $sentence;

        return $this;
    }

    public function getPersonnage(): ?string
    {
        return $this->personnage;
    }

    public function setPersonnage(string $personnage): static
    {
        $this->personnage = $personnage;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getOfUser(): Collection
    {
        return $this->ofUser;
    }

    public function addOfUser(User $ofUser): static
    {
        if (!$this->ofUser->contains($ofUser)) {
            $this->ofUser->add($ofUser);
        }

        return $this;
    }

    public function removeOfUser(User $ofUser): static
    {
        $this->ofUser->removeElement($ofUser);

        return $this;
    }
}
