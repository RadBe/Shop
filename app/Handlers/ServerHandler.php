<?php


namespace App\Handlers;


use App\Repository\Server\ServerRepository;

class ServerHandler
{
    private $serverRepository;

    public function __construct(ServerRepository $serverRepository)
    {
        $this->serverRepository = $serverRepository;
    }

    public function getServers(): array
    {
        return $this->serverRepository->getAll();
    }
}