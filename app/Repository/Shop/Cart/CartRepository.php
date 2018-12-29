<?php


namespace App\Repository\Shop\Cart;


use App\Entity\Shop\Cart;

interface CartRepository
{
    public function create(Cart $cart): void;
}