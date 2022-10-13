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

    public function __construct()
    {
        $this->player_id = new ArrayCollection();
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

    public function addPlayerId(Player $playerId): self
    {
        if (!$this->player_id->contains($playerId)) {
            $this->player_id->add($playerId);
        }

        return $this;
    }

    public function removePlayerId(Player $playerId): self
    {
        $this->player_id->removeElement($playerId);

        return $this;
    }
}
