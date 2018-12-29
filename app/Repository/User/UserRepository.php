<?php


namespace App\Repository\User;


use App\Entity\User;

interface UserRepository
{
    public function findById(int $id): ?User;

    public function findByName(string $name): ?User;

    public function update(User $user): void;
}