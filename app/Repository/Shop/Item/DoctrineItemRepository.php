<?php


namespace App\Repository\Shop\Item;


use App\Entity\Shop\Item;
use App\Repository\DoctrineConstructor;

class DoctrineItemRepository implements ItemRepository
{
    use DoctrineConstructor;

    public function getAll(): array
    {
        return $this->er->findAll();
    }

    public function find(int $id): ?Item
    {
        return $this->er->find($id);
    }

    public function create(Item $item): void
    {
        $this->em->persist($item);
        $this->em->flush();
    }

    public function update(Item $item): void
    {
        $this->em->merge($item);
        $this->em->flush();
    }

    public function delete(Item $item): void
    {
        $this->em->remove($item);
        $this->em->flush();
    }
}