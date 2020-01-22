<?php

namespace App\Domains\Repositories;

use Doctrine\ORM\EntityRepository;

abstract class AbstractRepository extends EntityRepository
{
    protected function repository()
    {
        return $this->getEntityManager()->getRepository($this->getEntityName());
    }
}