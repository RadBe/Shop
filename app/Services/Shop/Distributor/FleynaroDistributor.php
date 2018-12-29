<?php


namespace App\Services\Shop\Distributor;


use App\Entity\Server;
use App\Entity\Shop\Fleynaro;
use App\Entity\Shop\Item;
use App\Entity\User;
use App\Repository\Shop\Fleynaro\FleynaroRepository;

class FleynaroDistributor implements Distributor
{
    private $fleynaroRepository;

    public function __construct(FleynaroRepository $repository)
    {
        $this->fleynaroRepository = $repository;
    }

    public function distribute(User $user, Server $server, Item $item, int $amount): void
    {
        $entity = new Fleynaro(
            $server,
            $user->getUuid(),
            $item->getExtraArray()['id'],
            $amount
        );

        $this->fleynaroRepository->create($entity);
    }
}