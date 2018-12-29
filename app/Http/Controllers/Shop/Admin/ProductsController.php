<?php


namespace App\Http\Controllers\Shop\Admin;


use App\Entity\Shop\Category;
use App\Entity\Shop\Item;
use App\Handlers\Shop\Admin\ProductsHandler;
use App\Http\Controllers\Controller;
use App\Repository\Shop\Product\ProductRepository;
use Illuminate\Http\JsonResponse;

class ProductsController extends Controller
{
    public function render(ProductsHandler $handler, ProductRepository $productRepository)
    {
        //dd($productRepository->find(19)->__toArray());
        return new JsonResponse([
            'items' => array_map(function (Item $item) {
                return $item->__toArray();
            }, $handler->getItems()),
            'categories' => array_map(function (Category $category) {
                return $category->__toArray();
            }, $handler->getCategories())
        ]);
    }
}