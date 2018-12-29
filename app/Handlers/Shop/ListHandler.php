<?php


namespace App\Handlers\Shop;


use App\Entity\Server;
use App\Exceptions\ServerNotFoundException;
use App\Repository\Server\ServerRepository;
use App\Repository\Shop\Category\CategoryRepository;
use App\Repository\Shop\Product\ProductRepository;
use Illuminate\Pagination\LengthAwarePaginator;

class ListHandler
{
    private $productRepository;

    private $categoryRepository;

    private $serverRepository;

    public function __construct(
        ProductRepository $productRepository,
        CategoryRepository $categoryRepository,
        ServerRepository $serverRepository)
    {
        $this->productRepository = $productRepository;
        $this->categoryRepository = $categoryRepository;
        $this->serverRepository = $serverRepository;
    }

    public function getServer(int $id): Server
    {
        $server = $this->serverRepository->find($id);
        if(is_null($server)) {
            throw new ServerNotFoundException($id);
        }

        return $server;
    }

    public function getProducts(array $search, int $page): LengthAwarePaginator
    {
        return $this->productRepository->getAll($search, true, $page);
    }

    public function getCategories(Server $server): array
    {
        return $this->categoryRepository->getAll($server);
    }
}