<?php


namespace App\Repository\Server;


use App\Entity\Server;

interface ServerRepository
{
    public function getAll(bool $enabled = true): array;

    public function find(int $id): ?Server;
}