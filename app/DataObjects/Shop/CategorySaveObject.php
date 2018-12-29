<?php


namespace App\DataObjects\Shop;


use App\Entity\Server;

class CategorySaveObject
{
    /**
     * @var Server
     */
    private $server;

    /**
     * @var string
     */
    private $name;

    /**
     * @var int
     */
    private $weight;

    public function __construct(Server $server, string $name, int $weight)
    {
        $this->server = $server;
        $this->name = $name;
        $this->weight = $weight;
    }

    /**
     * @return Server
     */
    public function getServer(): Server
    {
        return $this->server;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return int
     */
    public function getWeight(): int
    {
        return $this->weight;
    }
}