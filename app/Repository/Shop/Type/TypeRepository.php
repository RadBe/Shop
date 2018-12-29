<?php


namespace App\Repository\Shop\Type;


use App\Entity\Shop\Type;

interface TypeRepository
{
    public function getAll(): array;

    public function find(string $id): ?Type;
}