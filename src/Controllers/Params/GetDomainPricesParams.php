<?php

namespace App\Controllers\Params;

use App\Validators\DomainValidator;
use yii\base\Model;

class GetDomainPricesParams extends Model
{
    /** @var string */
    public $search;

    public function rules()
    {
        return [
            ['search', 'required'],
            ['search', DomainValidator::class]
        ];
    }
}
