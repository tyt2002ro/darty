<?php

namespace App\Repository;

use App\Entity\GameThrow;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<GameThrow>
 *
 * @method GameThrow|null find($id, $lockMode = null, $lockVersion = null)
 * @method GameThrow|null findOneBy(array $criteria, array $orderBy = null)
 * @method GameThrow[]    findAll()
 * @method GameThrow[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GameThrowRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, GameThrow::class);
    }

    public function save(GameThrow $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(GameThrow $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findPlayerDataForThrow($gameId, $playerId): array
    {

        $conn = $this->getEntityManager()->getConnection();

        $sql = '
            SELECT coalesce(sum(GameThrow.points), 0) AS pointsTotal,
                        coalesce(avg(GameThrow.points), 0) AS pointsAverage,
                        3-mod(count(GameThrow.points), 3) AS legThrows,
                        count(GameThrow.points) AS totalThrows
                FROM game_throw as GameThrow
                WHERE GameThrow.game_id = :game_id
                    AND GameThrow.player_id = :player_id
            ';
        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery(['game_id' => $gameId, 'player_id' => $playerId]);

        $result = $resultSet->fetchAllAssociative();

        if ($result) {
            return $result[0];
        }
        return [];
    }

    public function getRecorderPoints($gameId, $playerId): mixed
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = '
            SELECT (game.type - coalesce(sum(game_throw.points), 0)) AS pointsLeft
                FROM game_throw
                RIGHT JOIN game on game_throw.game_id = game.id
            where game_throw.game_id = :game_id and game_throw.player_id = :player_id
            ';
        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery(['game_id' => $gameId, 'player_id' => $playerId]);

        $result = $resultSet->fetchAllAssociative();

        return $result[0]['pointsLeft'];
    }
}
