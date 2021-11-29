<?php

namespace app\modules\marketplace\models\entity;

use yii\base\Model;

class OzonAttributeValue extends Model
{
    public $dictionary_value_id;
    public $value;

    public function rules()
    {
        return [
            ['dictionary_value_id', 'integer'],
            ['value', 'string']
        ];
    }
}