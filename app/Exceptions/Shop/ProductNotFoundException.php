<?php


namespace App\Exceptions\Shop;


use App\Exceptions\RuntimeException;
use Throwable;

class ProductNotFoundException extends RuntimeException
{
    public function __construct(int $id, int $code = 0, Throwable $previous = null)
    {
        $message = "Товар #$id не найден!";
        parent::__construct($message, $code, $previous);
    }
}