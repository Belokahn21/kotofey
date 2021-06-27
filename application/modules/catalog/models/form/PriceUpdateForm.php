<?php

namespace app\modules\catalog\models\form;


use yii\base\Model;

class PriceUpdateForm extends Model
{
    public $file;
    public $vendor_id;

    public function rules()
    {
        return [

            [['vendor_id'], 'required'],

            ['vendor_id', 'integer'],

            ['file', 'file']
        ];
    }
}