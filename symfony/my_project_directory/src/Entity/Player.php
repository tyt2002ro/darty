<?php

namespace App\Entity;

use App\Repository\PlayerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PlayerRepository::class)]
class Player
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $firstname = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $lastname = null;

    #[ORM\Column(length: 255)]
    private ?string $nickname = null;

    #[ORM\OneToMany(mappedBy: 'player_id', targetEntity: GameThrow::class, orphanRemoval: true)]
    private Collection $gameThrows;

    public function __construct()
    {
        $this->gameThrows = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(?string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(?string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getNickname(): ?string
    {
        return $this->nickname;
    }

    public function setNickname(string $nickname): self
    {
        $this->nickname = $nickname;

        return $this;
    }

    /**
     * @return Collection<int, GameThrow>
     */
    public function getGameThrows(): Collection
    {
        return $this->gameThrows;
    }

    public function addGameThrow(GameThrow $gameThrow): self
    {
        if (!$this->gameThrows->contains($gameThrow)) {
            $this->gameThrows->add($gameThrow);
            $gameThrow->setPlayer($this);
        }

        return $this;
    }

    public function removeGameThrow(GameThrow $gameThrow): self
    {
        if ($this->gameThrows->removeElement($gameThrow)) {
            // set the owning side to null (unless already changed)
            if ($gameThrow->getPlayer() === $this) {
                $gameThrow->setPlayer(null);
            }
        }

        return $this;
    }
}
