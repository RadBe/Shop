<?php


namespace App\Repository\Shop\Pack;


use App\Entity\Shop\Pack;
use App\Entity\Shop\Product;
use App\Repository\DoctrineConstructor;

class DoctrinePackRepository implements PackRepository
{
    use DoctrineConstructor;

    public function create(Pack $pack): void
    {
        $this->em->persist($pack);
        $this->em->flush();
    }

    public function deleteAll(Product $product): void
    {
        $this->er->createQueryBuilder('p')
            ->delete()
            ->where('p.product = :product')
            ->setParameter('product', $product)
            ->getQuery()
            ->execute();
    }
}