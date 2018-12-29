<?php


namespace App\Handlers\Shop\Admin\Add;


use App\DataObjects\Shop\ProductSaveObject;
use App\Entity\Shop\Category;
use App\Entity\Shop\Item;
use App\Entity\Shop\Product;
use App\Exceptions\Shop\CategoryNotFoundException;
use App\Exceptions\Shop\ItemNotFoundException;
use App\Repository\Shop\Category\CategoryRepository;
use App\Repository\Shop\Item\ItemRepository;
use App\Repository\Shop\Product\ProductRepository;
use App\Services\Shop\Image\Image;
use Illuminate\Http\UploadedFile;

class OneHandler
{
    private $productRepository;

    private $itemRepository;

    private $categoryRepository;

    public function __construct(
        ProductRepository $productRepository,
        ItemRepository $itemRepository,
        CategoryRepository $categoryRepository)
    {
        $this->productRepository = $productRepository;
        $this->itemRepository = $itemRepository;
        $this->categoryRepository = $categoryRepository;
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

    public function getCategories(): array
    {
        return $this->categoryRepository->getAll();
    }

    public function getCategory(int $id): Category
    {
        $category = $this->categoryRepository->find($id);
        if(is_null($category)) {
            throw new CategoryNotFoundException($id);
        }

        return $category;
    }

    public function handle(ProductSaveObject $save): Product
    {
        $product = new Product(
            $save->getItem(),
            $save->getCategory(),
            $save->getAmount(),
            $save->getPrice(),
            0,
            null,
            $save->getGroups(),
            $save->getName()
        );

        $this->productRepository->create($product);

        $this->image($save->getPicture(), $product);

        return $product;
    }

    private function image(?UploadedFile $file, Product $product): void
    {
        $fileName = "product_{$product->getId()}";

        if(!is_null($file)) {
            $file->move(Image::DIR, $fileName . '.png');
            $product->setPicture($fileName);
            $this->productRepository->update($product);
        }
    }
}