<?php


namespace App\Repository\Shop\Product;


use App\Entity\Shop\Product;
use Illuminate\Pagination\LengthAwarePaginator;

interface ProductRepository
{
    public function getAll(array $search = [], bool $enabled = true, int $page = 1): LengthAwarePaginator;

    public function find(int $id): ?Product;

    public function create(Product $product): void;

    public function update(Product $product): void;

    public function delete(Product $product): void;
}