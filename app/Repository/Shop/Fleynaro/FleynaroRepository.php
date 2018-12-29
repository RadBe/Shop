<?php


namespace App\Repository\Shop\Fleynaro;


use App\Entity\Shop\Fleynaro;

interface FleynaroRepository
{
    public function create(Fleynaro $entity): void;
}