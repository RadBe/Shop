<?php


namespace App\Exceptions\Shop;


use App\Exceptions\RuntimeException;
use Throwable;

class TypeNotFoundException extends RuntimeException
{
    public function __construct(string $type, int $code = 0, Throwable $previous = null)
    {
        $message = "Тип #$type не найден!";
        parent::__construct($message, $code, $previous);
    }
}