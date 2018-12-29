<?php


namespace App\Services\Settings\Repository;


use App\Repository\DoctrineClearCache;
use App\Services\Settings\Setting;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

class DoctrineRepository implements Repository
{
    use DoctrineClearCache;

    private $em;

    private $er;

    public function __construct(EntityManagerInterface $em, EntityRepository $er)
    {
        $this->em = $em;
        $this->er = $er;
    }

    public function getAll(): array
    {
        return $this->er->createQueryBuilder('settings')
            ->select()
            ->getQuery()
            ->useResultCache(true)
            ->getResult();
    }

    public function create(Setting $setting): void
    {
        $this->clearResultCache();
        $this->em->persist($setting);
        $this->em->flush();
    }

    public function update(Setting $setting): void
    {
        $this->clearResultCache();
        $this->em->merge($setting);
        $this->em->flush();
    }

    public function delete(Setting $setting): void
    {
        $this->clearResultCache();
        $this->em->remove($setting);
        $this->em->flush();
    }

    protected function getEntityManager(): EntityManagerInterface
    {
        return $this->em;
    }
}