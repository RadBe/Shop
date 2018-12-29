<?php


namespace App\Repository\Shop\Product;


use App\Entity\Shop\Product;
use App\Repository\PaginatedDoctrineConstructor;
use Illuminate\Pagination\LengthAwarePaginator;
use LaravelDoctrine\ORM\Pagination\PaginatesFromParams;

class DoctrineProductRepository implements ProductRepository
{
    use PaginatedDoctrineConstructor, PaginatesFromParams;

    private const PER_PAGE = 10;

    public function getAll(array $search = [], bool $enabled = true, int $page = 1): LengthAwarePaginator
    {
        $query = $this->er->createQueryBuilder('p')
            ->select('p', 'c', 's', 'i')
            ->join('p.category', 'c')
            ->join('c.server', 's')
            ->leftJoin('p.item', 'i');

        $where = '';

        $category = $search['category'] ?? null;
        $name = $search['name'] ?? null;
        $server = $search['server'] ?? null;

        if(!empty($server)) {
            $where .= 'AND c.server = :server ';
            $query->setParameter('server', $server);
        }

        if(!empty($category)) {
            $where .= 'AND p.category = :category ';
            $query->setParameter('category', $category);
        }

        if(!empty($name)) {
            $where .= 'AND (p.name LIKE :name OR i.name LIKE :name)';
            $query->setParameter('name', "%$name%");
        }

        if($enabled) {
            $where .= 'AND s.enabled = 1';
        }

        if(!empty($where)) {
            $where = substr($where, 3);
            $query->where($where);
        }

        $query->orderBy('c.weight', 'ASC');

        return $this->paginate($query->getQuery(), static::PER_PAGE, $page, false);
    }

    public function find(int $id): ?Product
    {
        return $this->er->find($id);
    }

    public function create(Product $product): void
    {
        $this->em->persist($product);
        $this->em->flush();
    }

    public function update(Product $product): void
    {
        $this->em->merge($product);
        $this->em->flush();
    }

    public function delete(Product $product): void
    {
        $this->em->remove($product);
        $this->em->flush();
    }
}