<?php


namespace App\Repository\Server;


use App\Entity\Server;
use App\Repository\DoctrineConstructor;

class DoctrineServerRepository implements ServerRepository
{
    use DoctrineConstructor;

    public function getAll(bool $enabled = true): array
    {
        $query = $this->er->createQueryBuilder('server');
        if($enabled) {
            $query->where('server.enabled = 1');
        }

        $query = $query->getQuery();
        if($enabled) {
            $query->useResultCache(true);
        }

        return $query->getResult();
    }

    public function find(int $id): ?Server
    {
        return $this->er->find($id);
    }
}