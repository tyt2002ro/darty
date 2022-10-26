<?php

namespace App\Entity;

use App\Repository\GameRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GameRepository::class)]
class Game
{
    public const SINGLE_OUT = 'Single-Out';
    public const DOUBLE_OUT = 'Double-Out';

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $type = null;

    #[ORM\Column(length: 100)]
    private ?string $game_option = null;

    #[ORM\ManyToMany(targetEntity: Player::class)]
    private Collection $player_id;

    #[ORM\OneToMany(mappedBy: 'game_id', targetEntity: GameThrow::class, orphanRemoval: true)]
    private Collection $gameThrows;

    public function __construct()
    {
        $this->player_id = new ArrayCollection();
        $this->gameThrows = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?int
    {
        return $this->type;
    }

    public function setType(int $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getGameOption(): ?string
    {
        return $this->game_option;
    }

    public function setGameOption(string $game_option): self
    {
        $this->game_option = $game_option;

        return $this;
    }

    /**
     * @return Collection<int, Player>
     */
    public function getPlayerId(): Collection
    {
        return $this->player_id;
    }

    public function addPlayerId(Player $player): self
    {
        if (!$this->player_id->contains($player)) {
            $this->player_id->add($player);
        }

        return $this;
    }

    public function removePlayerId(Player $player): self
    {
        $this->player_id->removeElement($player);

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
            $gameThrow->setGame($this);
        }

        return $this;
    }

    public function removeGameThrow(GameThrow $gameThrow): self
    {
        if ($this->gameThrows->removeElement($gameThrow)) {
            // set the owning side to null (unless already changed)
            if ($gameThrow->getGame() === $this) {
                $gameThrow->setGame(null);
            }
        }

        return $this;
    }

    public function getSortedById(): array
    {
        $arr = $this->player_id->toArray();
        usort($arr, function($a, $b) {
            if ($a->getId() > $b->getId()) {
                return -1;
            }
        });



        return $arr;
    }
}
