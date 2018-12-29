<?php


namespace App\Repository\Shop\Fleynaro;


use App\Entity\Shop\Fleynaro;
use App\Repository\DoctrineConstructor;

class DoctrineFleynaroRepository implements FleynaroRepository
{
    use DoctrineConstructor;

    public function create(Fleynaro $entity): void
    {
        $this->em->persist($entity);
        $this->em->flush();
    }
}