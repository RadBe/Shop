<?php


namespace App\Repository\Shop\Cart;


use App\Entity\Shop\Cart;
use App\Repository\DoctrineConstructor;

class DoctrineCartRepository implements CartRepository
{
    use DoctrineConstructor;

    public function create(Cart $cart): void
    {
        $this->em->persist($cart);
        $this->em->flush();
    }
}