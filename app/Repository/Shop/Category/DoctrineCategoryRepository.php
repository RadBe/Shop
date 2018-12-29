<?php


namespace App\Repository\Shop\Category;


use App\Entity\Server;
use App\Entity\Shop\Category;
use App\Repository\DoctrineConstructor;

class DoctrineCategoryRepository implements CategoryRepository
{
    use DoctrineConstructor;

    public function getAll(?Server $server = null): array
    {
        $query = $this->er->createQueryBuilder('c');

        if(!is_null($server)) {
            $query->where('c.server = :server')
                ->setParameter('server', $server);
        }

        return $query->getQuery()->getResult();
    }

    public function find(int $id): ?Category
    {
        return $this->er->find($id);
    }

    public function create(Category $category): void
    {
        $this->em->persist($category);
        $this->em->flush();
    }

    public function update(Category $category): void
    {
        $this->em->merge($category);
        $this->em->flush();
    }

    public function delete(Category $category): void
    {
        $this->em->remove($category);
        $this->em->flush();
    }
}