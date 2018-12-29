<?php


namespace App\DataObjects\Shop;


use App\Entity\Shop\Product;
use App\Entity\User;

class PipelineObject
{
    /**
     * @var User
     */
    private $user;

    /**
     * @var Product
     */
    private $product;

    /**
     * @var int
     */
    private $amount;

    /**
     * @var int
     */
    private $resultSum;

    /**
     * PipelineObject constructor.
     *
     * @param User $user
     * @param Product $product
     * @param int $amount
     */
    public function __construct(User $user, Product $product, int $amount)
    {
        $this->user = $user;
        $this->product = $product;
        $this->amount = $amount;
        $this->resultSum = $product->getPrice() * $amount;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @return Product
     */
    public function getProduct(): Product
    {
        return $this->product;
    }

    /**
     * @return int
     */
    public function getAmount(): int
    {
        return $this->amount;
    }

    /**
     * @param int $amount
     */
    public function setAmount(int $amount): void
    {
        $this->amount = $amount;
    }

    /**
     * @return int
     */
    public function getResultSum(): int
    {
        return $this->resultSum;
    }

    /**
     * @param int $resultSum
     */
    public function setResultSum(int $resultSum): void
    {
        $this->resultSum = $resultSum;
    }
}