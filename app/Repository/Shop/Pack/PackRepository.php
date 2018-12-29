<?php


namespace App\Repository\Shop\Pack;


use App\Entity\Shop\Pack;
use App\Entity\Shop\Product;

interface PackRepository
{
    public function create(Pack $pack): void;

    public function deleteAll(Product $product): void;
}