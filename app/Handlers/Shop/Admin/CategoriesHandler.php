<?php


namespace App\Handlers\Shop\Admin;


use App\Entity\Shop\Category;
use App\Exceptions\Shop\CategoryNotFoundException;
use App\Repository\Server\ServerRepository;
use App\Repository\Shop\Category\CategoryRepository;

class CategoriesHandler
{
    private $categoryRepository;

    private $serverRepository;

    public function __construct(CategoryRepository $categoryRepository, ServerRepository $serverRepository)
    {
        $this->categoryRepository = $categoryRepository;
        $this->serverRepository = $serverRepository;
    }

    public function getCategories(): array
    {
        return $this->categoryRepository->getAll();
    }

    public function getServers(): array
    {
        return $this->serverRepository->getAll();
    }

    public function getCategory(int $id): Category
    {
        $category = $this->categoryRepository->find($id);
        if(is_null($category)) {
            throw new CategoryNotFoundException($id);
        }

        return $category;
    }

    public function delete(Category $category): void
    {
        $this->categoryRepository->delete($category);
    }
}