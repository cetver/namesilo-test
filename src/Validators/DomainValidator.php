<?php

namespace App\Validators;

use yii\validators\Validator;

class DomainValidator extends Validator
{
    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();
        if ($this->message === null) {
            $this->message = \Yii::t('yii', '{attribute} is invalid.');
        }
    }

    public function validateAttribute($model, $attribute)
    {
        $filteredValue = filter_var($model->$attribute, FILTER_VALIDATE_DOMAIN, FILTER_FLAG_HOSTNAME);
        if ($filteredValue === false) {
            $this->addError($model, $attribute, $this->message);
        }
    }
}