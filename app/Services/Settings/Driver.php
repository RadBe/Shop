<?php


namespace App\Services\Settings;


use App\Services\Settings\Repository\Repository;

class Driver
{
    private $repository;

    public function __construct(Repository $repository)
    {
        $this->repository = $repository;
    }

    public function load(): array
    {
        return $this->repository->getAll();
    }

    public function repository(): Repository
    {
        return $this->repository;
    }
}