<?php

namespace App\Controllers;

use App\Controllers\Dtos\DomainDto;
use App\Controllers\Params\GetDomainPricesParams;
use App\Domains\Services\DomainResponseService;
use yii\filters\ContentNegotiator;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\web\Request;
use yii\web\Response;

class DomainsController extends Controller
{
    /**
     * @var GetDomainPricesParams
     */
    private $domainPricesParams;
    /**
     * @var Request
     */
    private $request;
    /**
     * @var DomainResponseService
     */
    private $domainResponse;

    public function __construct(
        $id,
        $module,
        GetDomainPricesParams $domainPricesParams,
        Request $request,
        DomainResponseService $domainResponse,
        $config = []
    )
    {
        $this->domainPricesParams = $domainPricesParams;
        $this->request = $request;
        $this->domainResponse = $domainResponse;
        parent::__construct($id, $module, $config);
    }

    /**
     * @inheritdoc
     */
    public function behaviors(): array
    {
        $behaviors = parent::behaviors();
        $behaviors['contentNegotiator'] = [
            'class' => ContentNegotiator::class,
            'formats' => [
                'application/json' => Response::FORMAT_JSON,
            ],
        ];
        return $behaviors;
    }

    /**
     * Get domain with prices
     *
     * @return DomainDto[]
     * @throws BadRequestHttpException
     */
    public function actionCheck(): array
    {
        if (!$this->domainPricesParams->load($this->request->get(), '') ||
            !$this->domainPricesParams->validate()
        ) {
            throw new BadRequestHttpException();
        }

        return $this->domainResponse->fetch($this->domainPricesParams->search);
    }
}
