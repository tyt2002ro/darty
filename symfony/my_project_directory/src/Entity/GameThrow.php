<?php

namespace App\Entity;

use App\Repository\GameThrowRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GameThrowRepository::class)]
class GameThrow
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $points = null;

    #[ORM\ManyToOne(inversedBy: 'gameThrows')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Game $game_id = null;

    #[ORM\ManyToOne(inversedBy: 'gameThrows')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Player $player_id = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $throw_order = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPoints(): ?int
    {
        return $this->points;
    }

    public function setPoints(int $points): self
    {
        $this->points = $points;

        return $this;
    }

    public function getGameId(): ?Game
    {
        return $this->game_id;
    }

    public function setGameId(?Game $game_id): self
    {
        $this->game_id = $game_id;

        return $this;
    }

    public function getPlayerId(): ?Player
    {
        return $this->player_id;
    }

    public function setPlayerId(?Player $player_id): self
    {
        $this->player_id = $player_id;

        return $this;
    }

    public function getThrowOrder(): ?int
    {
        return $this->throw_order;
    }

    public function setThrowOrder(int $throw_order): self
    {
        $this->throw_order = $throw_order;

        return $this;
    }
}
