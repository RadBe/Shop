<?php


namespace App\Providers;


use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping\ClassMetadata;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        //
    }

    public function register(): void
    {
        $repositories = [
            \App\Services\Settings\Repository\Repository::class => [
                'concrete' => \App\Services\Settings\Repository\DoctrineRepository::class,
                'entity' => \App\Services\Settings\Setting::class
            ],
            \App\Repository\Server\ServerRepository::class => [
                'concrete' => \App\Repository\Server\DoctrineServerRepository::class,
                'entity' => \App\Entity\Server::class
            ],
            \App\Repository\User\UserRepository::class => [
                'concrete' => \App\Repository\User\DoctrineUserRepository::class,
                'entity' => \App\Entity\User::class
            ],

            //Shop
            \App\Repository\Shop\Type\TypeRepository::class => [
                'concrete' => \App\Repository\Shop\Type\DoctrineTypeRepository::class,
                'entity' => \App\Entity\Shop\Type::class
            ],
            \App\Repository\Shop\Category\CategoryRepository::class => [
                'concrete' => \App\Repository\Shop\Category\DoctrineCategoryRepository::class,
                'entity' => \App\Entity\Shop\Category::class
            ],
            \App\Repository\Shop\Item\ItemRepository::class => [
                'concrete' => \App\Repository\Shop\Item\DoctrineItemRepository::class,
                'entity' => \App\Entity\Shop\Item::class
            ],
            \App\Repository\Shop\Product\ProductRepository::class => [
                'concrete' => \App\Repository\Shop\Product\DoctrineProductRepository::class,
                'entity' => \App\Entity\Shop\Product::class
            ],
            \App\Repository\Shop\Pack\PackRepository::class => [
                'concrete' => \App\Repository\Shop\Pack\DoctrinePackRepository::class,
                'entity' => \App\Entity\Shop\Pack::class
            ],
            \App\Repository\Shop\Cart\CartRepository::class => [
                'concrete' => \App\Repository\Shop\Cart\DoctrineCartRepository::class,
                'entity' => \App\Entity\Shop\Cart::class
            ],
            \App\Repository\Shop\Fleynaro\FleynaroRepository::class => [
                'concrete' => \App\Repository\Shop\Fleynaro\DoctrineFleynaroRepository::class,
                'entity' => \App\Entity\Shop\Fleynaro::class
            ],
        ];

        foreach ($repositories as $repository => $data)
        {
            $this->app->when($data['concrete'])
                ->needs(EntityRepository::class)
                ->give(function () use ($data) {
                    return $this->buildEntityRepository($data['entity']);
                });

            $this->app->singleton($repository, $data['concrete']);
        }
    }

    private function buildEntityRepository(string $entity)
    {
        return new EntityRepository(
            $this->app->make(EntityManagerInterface::class),
            new ClassMetadata($entity)
        );
    }
}