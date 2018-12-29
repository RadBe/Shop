<?php


namespace App\Handlers\Shop\Admin;


use App\Entity\Shop\Item;
use App\Exceptions\Shop\ItemNotFoundException;
use App\Repository\Shop\Item\ItemRepository;
use App\Repository\Shop\Type\TypeRepository;

class ItemsHandler
{
    private $itemRepository;

    private $typeRepository;

    public function __construct(ItemRepository $itemRepository, TypeRepository $typeRepository)
    {
        $this->itemRepository = $itemRepository;
        $this->typeRepository = $typeRepository;
    }

    public function getTypes(): array
    {
        return $this->typeRepository->getAll();
    }

    public function getItems(): array
    {
        return $this->itemRepository->getAll();
    }

    public function getItem(int $id): Item
    {
        $item = $this->itemRepository->find($id);
        if(is_null($item)) {
            throw new ItemNotFoundException($id);
        }

        return $item;
    }

    public function delete(Item $item): void
    {
        $this->itemRepository->delete($item);
    }
}