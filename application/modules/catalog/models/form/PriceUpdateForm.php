<?php

namespace app\modules\catalog\models\form;


use yii\base\Model;

class PriceUpdateForm extends Model
{
    public $file;
    public $vendor_id;
    public $delimiter;
    public $default_markup;
    public $force_markup;

    public function rules()
    {
        return [

            [['vendor_id'], 'required'],

            [['vendor_id', 'default_markup', 'force_markup'], 'integer'],

            ['delimiter', 'default', 'value' => ';'],
            ['delimiter', 'string'],

            ['file', 'file', 'skipOnEmpty' => false]
        ];
    }

    public function attributeLabels()
    {
        return [
            'delimiter' => 'Разделитель',
            'file' => 'Прайс-лист',
            'vendor_id' => 'Поставщик',
            'default_markup' => 'Наценка, если у товара отстуствует',
            'force_markup' => 'Принудительно проставить скидку',
        ];
    }
}