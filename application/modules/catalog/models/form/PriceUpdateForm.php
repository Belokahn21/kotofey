<?php

namespace app\modules\catalog\models\form;


use yii\base\Model;

class PriceUpdateForm extends Model
{
    public $file;
    public $vendor_id;
    public $delimiter;

    public function rules()
    {
        return [

            [['vendor_id'], 'required'],

            ['vendor_id', 'integer'],

            ['delimiter', 'default', 'value' => ';'],
            ['delimiter', 'string'],

            ['file', 'file']
        ];
    }

    public function attributeLabels()
    {
        return [
            'delimiter' => 'Разделитель',
            'file' => 'Прайс-лист',
            'vendor_id' => 'Поставщик',
        ];
    }
}