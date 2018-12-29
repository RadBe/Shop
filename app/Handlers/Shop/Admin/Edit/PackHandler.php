<?php


namespace App\Handlers\Shop\Admin\Edit;


use App\DataObjects\Shop\SavePackObject;
use App\Entity\Shop\Category;
use App\Entity\Shop\Item;
use App\Entity\Shop\Pack;
use App\Entity\Shop\Product;
use App\Exceptions\Shop\CategoryNotFoundException;
use App\Exceptions\Shop\ItemNotFoundException;
use App\Exceptions\Shop\ProductNotFoundException;
use App\Repository\Shop\Category\CategoryRepository;
use App\Repository\Shop\Item\ItemRepository;
use App\Repository\Shop\Pack\PackRepository;
use App\Repository\Shop\Product\ProductRepository;
use App\Services\Shop\Image\Image;
use Illuminate\Http\UploadedFile;

class PackHandler
{
    private $productRepository;

    private $itemRepository;

    private $categoryRepository;

    private $packRepository;

    public function __construct(
        ProductRepository $productRepository,
        ItemRepository $itemRepository,
        CategoryRepository $categoryRepository,
        PackRepository $packRepository)
    {
        $this->productRepository = $productRepository;
        $this->itemRepository = $itemRepository;
        $this->categoryRepository = $categoryRepository;
        $this->packRepository = $packRepository;
    }

    public function getProduct(int $id): Product
    {
        $product = $this->productRepository->find($id);
        if(is_null($product)) {
            throw new ProductNotFoundException($id);
        }

        return $product;
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

    public function handle(SavePackObject $save, Product $product): void
    {
        $product->setName($save->getName())
            ->setPrice($save->getPrice())
            ->setCategory($save->getCategory())
            ->setFor($save->getGroups());

        $this->packRepository->deleteAll($product);

        foreach ($save->getItems() as $item)
        {
            $pack = new Pack($product, $item[0]);
            $pack->setAmount($item[1]);
            $this->packRepository->create($pack);
        }

        $this->productRepository->update($product);

        if(!is_null($save->getPicture())) {
            $this->image($save->getPicture(), $product);
        }
    }

    private function image(UploadedFile $file, Product $product): void
    {
        $fileName = "product_{$product->getId()}";

        $file->move(Image::DIR, $fileName . '.png');
    }
}