<?php


namespace App\Services\Pipelines\Shop\Buy;


use App\DataObjects\Shop\PipelineObject;
use App\Exceptions\User\NoMoneyException;
use App\Repository\User\UserRepository;
use Closure;

class PaymentPipeline
{
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function handle(PipelineObject $po, Closure $next)
    {
        if(!$po->getUser()->hasMoney($po->getResultSum())) {
            throw new NoMoneyException("Недостаточно средств на балансе! Необходимая сумма: " . $po->getResultSum());
        }

        $po->getUser()->withdrawMoney($po->getResultSum());

        $this->userRepository->update($po->getUser());

        return $next($po);
    }
}