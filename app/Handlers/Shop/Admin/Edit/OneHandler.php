<?php


namespace App\Handlers\Shop\Admin\Edit;


use App\DataObjects\Shop\ProductSaveObject;
use App\Entity\Shop\Category;
use App\Entity\Shop\Item;
use App\Entity\Shop\Product;
use App\Exceptions\Shop\CategoryNotFoundException;
use App\Exceptions\Shop\ItemNotFoundException;
use App\Exceptions\Shop\ProductNotFoundException;
use App\Repository\Shop\Category\CategoryRepository;
use App\Repository\Shop\Item\ItemRepository;
use App\Repository\Shop\Product\ProductRepository;
use App\Services\Shop\Image\Image;
use Illuminate\Http\UploadedFile;

class OneHandler
{
    private $productRepository;

    private $categoryRepository;

    private $itemRepository;

    public function __construct(ProductRepository $productRepository, CategoryRepository $categoryRepository, ItemRepository $itemRepository)
    {
        $this->productRepository = $productRepository;
        $this->categoryRepository = $categoryRepository;
        $this->itemRepository = $itemRepository;
    }

    public function getProduct(int $id): Product
    {
        $product = $this->productRepository->find($id);
        if(is_null($product)) {
            throw new ProductNotFoundException($id);
        }

        return $product;
    }

    public function getCategory(int $id): Category
    {
        $category = $this->categoryRepository->find($id);
        if(is_null($category)) {
            throw new CategoryNotFoundException($id);
        }

        return $category;
    }

    public function getItem(int $id): Item
    {
        $item = $this->itemRepository->find($id);
        if(is_null($item)) {
            throw new ItemNotFoundException($id);
        }

        return $item;
    }

    public function handle(ProductSaveObject $save, Product $product, bool $deletePicture = false): void
    {
        if(!is_null($save->getPicture())) {
            $product->setPicture("product_{$product->getId()}");
        } elseif ($deletePicture) {
            $product->setPicture(null);
            $this->imageDelete($product);
        }

        $product->setName($save->getName())
            ->setAmount($save->getAmount())
            ->setPrice($save->getPrice())
            ->setCategory($save->getCategory())
            ->setFor($save->getGroups())
            ->setItem($save->getItem());

        $this->productRepository->update($product);

        $this->image($save->getPicture(), $product);
    }

    private function image(?UploadedFile $file, Product $product): void
    {
        if(!is_null($file)) {
            $fileName = "product_{$product->getId()}";
            $file->move(Image::DIR, $fileName . '.png');
            $product->setPicture($fileName);
        }
    }

    private function imageDelete(Product $product): void
    {
        $file = Image::DIR . '/product_' . $product->getId() . '.png';
        if(is_file($file)) {
            @unlink($file);
        }
    }
}