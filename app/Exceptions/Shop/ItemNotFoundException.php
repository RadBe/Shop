<?php


namespace App\Exceptions\Shop;


use App\Exceptions\RuntimeException;

class ItemNotFoundException extends RuntimeException
{
    public function __construct(int $id, int $code = 0, \Throwable $previous = null)
    {
        $message = "Итем #$id не найден!";
        parent::__construct($message, $code, $previous);
    }
}