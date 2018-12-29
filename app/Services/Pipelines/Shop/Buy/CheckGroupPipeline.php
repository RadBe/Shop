<?php


namespace App\Services\Pipelines\Shop\Buy;


use App\DataObjects\Shop\PipelineObject;
use App\Entity\Group;
use App\Exceptions\RuntimeException;
use Closure;

class CheckGroupPipeline
{
    public function handle(PipelineObject $po, Closure $next)
    {
        if(!empty($po->getProduct()->getForArray())) {
            $canBuy = false;

            $allowedGroups = $po->getProduct()->getForArray();

            /* @var Group $group */
            foreach ($po->getUser()->getGroups()->toArray() as $group)
            {
                if(!is_null($group->getServer()) && $po->getProduct()->getCategory()->getServer()->getId() != $group->getServer()->getId()) {
                    continue;
                }

                if(in_array($group->getGroup(), $allowedGroups)) {
                    $canBuy = true;
                }
            }

            if(!$canBuy) {
                throw new RuntimeException('Вы не можете купить этот товар, т.к. не состоите в разрешенной группе!');
            }
        }

        return $next($po);
    }
}