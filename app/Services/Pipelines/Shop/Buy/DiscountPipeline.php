<?php


namespace App\Services\Pipelines\Shop\Buy;


use App\DataObjects\Shop\PipelineObject;
use App\Exceptions\UnexpectedValueException;
use Closure;

class DiscountPipeline
{
    public function handle(PipelineObject $po, Closure $next)
    {
        $discount = 0;
        if(
            $po->getProduct()->getDiscount() > 0 &&
            (is_null($po->getProduct()->getDiscountTime()) ||
            $po->getProduct()->getDiscountTime()->getTimestamp() > time())
        ) {
            $discount = $po->getProduct()->getDiscount();
        }

        if($discount > 0 && $discount < 100) {
            $sum = $po->getResultSum();
            $sum -= $sum * ($discount / 100);

            if($sum < 1) {
                throw new UnexpectedValueException('Сумма с учетом скидки меньше 1!');
            }

            $po->setResultSum($sum);
        }

        return $next($po);
    }
}