<?php


namespace App\Handlers\Shop;


use App\DataObjects\Shop\PipelineObject;
use App\Entity\Shop\Product;
use App\Entity\User;
use App\Exceptions\Shop\ProductNotFoundException;
use App\Repository\Shop\Product\ProductRepository;
use Illuminate\Pipeline\Pipeline;

class BuyHandler
{
    private $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function getProduct(int $id): Product
    {
        $product = $this->productRepository->find($id);
        if(is_null($product)) {
            throw new ProductNotFoundException($id);
        }

        return $product;
    }

    public function handle(Product $product, User $user, int $amount): PipelineObject
    {
        $po = app(Pipeline::class)
            ->send(new PipelineObject($user, $product, $amount))
            ->through([
                \App\Services\Pipelines\Shop\Buy\CheckGroupPipeline::class,
                \App\Services\Pipelines\Shop\Buy\DiscountPipeline::class,
                \App\Services\Pipelines\Shop\Buy\PaymentPipeline::class,
                \App\Services\Pipelines\Shop\ToCartPipeline::class,
                \App\Services\Pipelines\Shop\ToStoragePipeline::class,
            ])
            ->then(function ($po) {
                return $po;
            });

        return $po;
    }
}