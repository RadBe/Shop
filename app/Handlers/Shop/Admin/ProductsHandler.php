<?php


namespace App\Handlers\Shop\Admin;


use App\Repository\Shop\Category\CategoryRepository;
use App\Repository\Shop\Item\ItemRepository;

class ProductsHandler
{
    private $itemRepository;

    private $categoryRepository;

    public function __construct(ItemRepository $itemRepository, CategoryRepository $categoryRepository)
    {
        $this->itemRepository = $itemRepository;
        $this->categoryRepository = $categoryRepository;
    }

    public function getCategories(): array
    {
        return $this->categoryRepository->getAll();
    }

    public function getItems(): array
    {
        return $this->itemRepository->getAll();
    }
}