<?php


namespace App\Repository\Shop\Type;


use App\Entity\Shop\Type;
use App\Repository\DoctrineConstructor;

class DoctrineTypeRepository implements TypeRepository
{
    use DoctrineConstructor;

    public function getAll(): array
    {
        return $this->er->findAll();
    }

    public function find(string $id): ?Type
    {
        return $this->er->find($id);
    }
}