<?php

namespace App\Domains\Repositories;

class DomainRepository extends AbstractRepository
{
    /**
     * @param string $host
     * @param array $map
     *
     * @return array|\App\Domains\Models\Domain[]
     */
    public function findAllByHost(string $host, array $map)
    {
        $domains = [];
        foreach ($map as $topLevelDomain) {
            $domains[] = $host . '.' . $topLevelDomain;
        }

        return $this->findBy(['domain' => $domains]);
    }
}
