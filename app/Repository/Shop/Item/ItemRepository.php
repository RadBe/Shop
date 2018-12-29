<?php


namespace App\Repository\Shop\Item;


use App\Entity\Shop\Item;

interface ItemRepository
{
    public function getAll(): array;

    public function find(int $id): ?Item;

    public function create(Item $item): void;

    public function update(Item $item): void;

    public function delete(Item $item): void;
}