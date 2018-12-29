<?php


namespace App\Services\Shop\Distributor;


use App\Entity\Server;
use App\Entity\Shop\Item;
use App\Entity\User;

interface Distributor
{
    /**
     * @param User $user
     * @param Server $server
     * @param Item $item
     * @param int $amount
     */
    public function distribute(User $user, Server $server, Item $item, int $amount): void;
}