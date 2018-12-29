<?php


namespace App\Handlers\Shop\Admin\Add;


use App\DataObjects\Shop\CategorySaveObject;
use App\Entity\Server;
use App\Entity\Shop\Category;
use App\Exceptions\ServerNotFoundException;
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

    public function handle(CategorySaveObject $save): Category
    {
        $category = new Category(
            $save->getServer(),
            $save->getName(),
            $save->getWeight()
        );

        $this->categoryRepository->create($category);

        return $category;
    }
}