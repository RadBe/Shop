<?php


namespace App\Exceptions;


use App\Entity\Server;
use Throwable;

class ServerNotEnabled extends RuntimeException
{
    public function __construct(Server $server, int $code = 0, Throwable $previous = null)
    {
        parent::__construct("Сервер {$server->getName()} временно отключен!", $code, $previous);
    }
}