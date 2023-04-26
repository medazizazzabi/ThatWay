<?php

namespace App\Repository;

use App\Entity\Routes;
use App\Entity\Routestations;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class RoutestationsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Routestations::class);
    }

    /**
     * Returns all Routestations for a given RouteID.
     *
     * @param int $routeId
     * @return Routestations[]
     */
    public function findByRouteId(int $routeId): array
    {
        $query = $this->createQueryBuilder('r')
            ->select('r, s')
            ->join('r.stationid', 's')
            ->where('r.routeid = :routeid')
            ->orderBy('r.sequencenumber', 'ASC')
            ->setParameter('routeid', $routeId)
            ->getQuery();

        return $query->getResult();
    }

    public function findByRoute(Routes $route): array
    {
        return $this->findByRouteId($route->getId());
    }
}
