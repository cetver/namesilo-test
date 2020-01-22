<?php

namespace App\Domains\Services;

use App\Controllers\Dtos\DomainDto;
use App\Domains\Models\Domain;
use App\Domains\Models\Tld;
use Doctrine\ORM\EntityManager;

class DomainResponseService
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function fetch(string $host)
    {
        $response = [];
        $domainRepository = $this->entityManager->getRepository(Domain::class);
        $tldRepository = $this->entityManager->getRepository(Tld::class);

        $topLevelDomains = $tldRepository->findAll();
        $topLevelDomainList = array_column($topLevelDomains, 'tld');

        $domains = $domainRepository->findAllByHost($host, $topLevelDomainList);

        foreach ($topLevelDomains as $topLevelDomain) {
            $available = true;
            foreach ($domains as $domain) {
                if ($domain->topLevelDomain($topLevelDomainList) === $topLevelDomain->tld) {
                    $available = false;
                    break;
                }
            }

            $response[] = new DomainDto($topLevelDomain->tld, $host, $topLevelDomain->price, $available);
        }

        return $response;
    }
}