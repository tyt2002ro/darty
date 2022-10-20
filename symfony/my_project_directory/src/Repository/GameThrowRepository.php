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
        $entityManager = $this->getEntityManager();

        $sql = 'SELECT sum(GameThrow.points) as pointsTotal, avg(GameThrow.points) as pointsAverage, 
        3-mod(count(GameThrow.points),3) as legThrows, count(GameThrow.points) as totalThrows
         FROM App\Entity\GameThrow GameThrow
            WHERE GameThrow.game_id = ' . $gameId . '
            AND GameThrow.player_id = ' . $playerId;
        $query = $entityManager->createQuery($sql)->getResult();

        if($query){
            return $query[0];
        }
        return [];
    }
}
