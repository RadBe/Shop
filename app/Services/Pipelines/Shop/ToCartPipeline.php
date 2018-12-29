<?php


namespace App\Services\Pipelines\Shop;


use App\DataObjects\Shop\PipelineObject;
use App\Entity\Shop\Cart;
use App\Repository\Shop\Cart\CartRepository;
use Closure;

class ToCartPipeline
{
    private $cartRepository;

    public function __construct(CartRepository $cartRepository)
    {
        $this->cartRepository = $cartRepository;
    }

    public function handle(PipelineObject $po, Closure $next)
    {
        $cart = new Cart(
            $po->getUser(),
            $po->getProduct(),
            $po->getAmount()
        );

        $cart->setResultSum($po->getResultSum());
        $cart->setCompletedDate();

        $this->cartRepository->create($cart);

        return $next($po);
    }
}