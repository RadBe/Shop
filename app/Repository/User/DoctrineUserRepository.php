<?php


namespace App\Repository\User;


use App\Entity\User;
use App\Repository\DoctrineConstructor;

class DoctrineUserRepository implements UserRepository
{
    use DoctrineConstructor;

    public function findById(int $id): ?User
    {
        return $this->er->find($id);
    }

    public function findByName(string $name): ?User
    {
        return $this->er->findOneBy(['name' => $name]);
    }

    public function update(User $user): void
    {
        $this->em->merge($user);
        $this->em->flush();
    }
}