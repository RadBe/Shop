<?php


namespace App\Services\Pipelines\Shop;


use App\DataObjects\Shop\PipelineObject;
use App\Entity\Shop\Pack;
use App\Exceptions\RuntimeException;
use App\Services\Shop\Distributor\Distributor;
use Closure;

class ToStoragePipeline
{
    private $distributors = [];

    public function handle(PipelineObject $po, Closure $next)
    {
        if(!is_null($po->getProduct()->getItem())) {
            $distributor = $this->getDistributor($po->getProduct()->getItem()->getType()->getDistributor());

            for ($i = 0; $i < $po->getAmount(); $i++)
            {
                $distributor->distribute(
                    $po->getUser(),
                    $po->getProduct()->getCategory()->getServer(),
                    $po->getProduct()->getItem(),
                    $po->getProduct()->getAmount()
                );
            }
        } else {
            for ($i = 0; $i < $po->getAmount(); $i++)
            {
                /* @var Pack $pack */
                foreach ($po->getProduct()->getItems()->toArray() as $pack)
                {
                    $distributor = $this->getDistributor($pack->getItem()->getType()->getDistributor());

                    $distributor->distribute(
                        $po->getUser(),
                        $po->getProduct()->getCategory()->getServer(),
                        $pack->getItem(),
                        $pack->getAmount()
                    );
                }
            }
        }

        return $next($po);
    }

    private function getDistributor(string $class): Distributor
    {
        if(isset($this->distributors[$class])) {
            return $this->distributors[$class];
        }

        if(!class_exists($class)) {
            throw new RuntimeException("Класс дистрибьютора '$class' не найден!");
        }

        $distributor = app($class);
        $distributors[$class] = $distributor;

        return $distributor;
    }
}