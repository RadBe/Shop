<?php


namespace App\Repository\Shop\Category;


use App\Entity\Server;
use App\Entity\Shop\Category;

interface CategoryRepository
{
    public function getAll(?Server $server = null): array;

    public function find(int $id): ?Category;

    public function create(Category $category): void;

    public function update(Category $category): void;

    public function delete(Category $category): void;
}