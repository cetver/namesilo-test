<?php

use App\Controllers\DomainsController;
use App\Controllers\Params\GetDomainPricesParams;
use App\Domains\Services\DomainResponseService;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;
use yii\di\Container;
use yii\web\Request;

return [
    'singletons' => [
        EntityManager::class => function () {
            $conn = [
                'driver' => 'pdo_sqlite',
                'path' => dirname(__DIR__) . '/db.sqlite',
            ];

            $config = Setup::createAnnotationMetadataConfiguration([dirname(__DIR__) . '/src'], true, null, null, false);
            return EntityManager::create($conn, $config);
        },
        [
            'class' => DomainsController::class,
            'definition' => function (Container $container, $params, $config) {
                /** @var yii\web\Request $request */
                $request = $container->get(Request::class);
                /** @var DomainResponseService $domainResponseService */
                $domainResponseService = $container->get(DomainResponseService::class);

                return new DomainsController(
                    $params[0],
                    $params[1],
                    new GetDomainPricesParams(),
                    $request,
                    $domainResponseService,
                    $config
                );
            }
        ],
        [
            'class' => DomainResponseService::class,
            'definition' => function (Container $container, $params, $config) {
                /** @var EntityManager $entityManager */
                $entityManager = $container->get(EntityManager::class);

                return new DomainResponseService($entityManager);
            }
        ],
    ]
];
