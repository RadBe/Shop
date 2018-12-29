<?php


namespace App\Http\Controllers;


use App\Entity\Server;
use App\Handlers\ServerHandler;
use Illuminate\Http\JsonResponse;

class ServersController extends Controller
{
    public function render(ServerHandler $handler)
    {
        return new JsonResponse([
            'servers' => array_map(function (Server $server) {
                return $server->__toArray();
            }, $handler->getServers())
        ]);
    }
}