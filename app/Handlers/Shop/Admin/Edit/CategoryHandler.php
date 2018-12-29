<?php


namespace App\Handlers\Shop\Admin\Edit;


use App\DataObjects\Shop\CategorySaveObject;
use App\Entity\Server;
use App\Entity\Shop\Category;
use App\Exceptions\ServerNotFoundException;
use App\Exceptions\Shop\CategoryNotFoundException;
use App\Repository\Server\ServerRepository;
use App\Repository\Shop\Category\CategoryRepository;

class CategoryHandler
{
    private $categoryRepository;

    private $serverRepository;

    public function __construct(CategoryRepository $categoryRepository, ServerRepository $serverRepository)
    {
        $this->categoryRepository = $categoryRepository;
        $this->serverRepository = $serverRepository;
    }

    public function getServers(): array
    {
        return $this->serverRepository->getAll();
    }

    public function getServer(int $id): Server
    {
        $server = $this->serverRepository->find($id);
        if(is_null($server)) {
            throw new ServerNotFoundException($id);
        }

        return $server;
    }

    public function getCategory(int $id): Category
    {
        $category = $this->categoryRepository->find($id);
        if(is_null($category)) {
            throw new CategoryNotFoundException($id);
        }

        return $category;
    }

    public function handle(CategorySaveObject $save, Category $category): void
    {
        $category->setName($save->getName())
            ->setWeight($save->getWeight())
            ->setServer($save->getServer());

        $this->categoryRepository->update($category);
    }
}