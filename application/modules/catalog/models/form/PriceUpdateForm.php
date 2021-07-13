<?php

namespace app\modules\catalog\models\form;

use yii\base\Model;

/**
 * PriceUpdateForm model
 * @property integer $file;
 * @property integer $vendor_id;
 * @property integer $delimiter;
 * @property integer $default_markup;
 * @property integer $force_markup;
 * @property integer $type_price;
 */
class PriceUpdateForm extends Model
{
    public $file;
    public $vendor_id;
    public $delimiter;
    public $default_markup;
    public $force_markup;
    public $type_price;
    public $related_key_filter;

    const TYPE_PRICE_BASE = 'base';
    const TYPE_PRICE_PURCHASE = 'purchase';

    public function rules()
    {
        return [

            [['vendor_id'], 'required'],

            [['vendor_id', 'default_markup', 'force_markup'], 'integer'],

            ['delimiter', 'default', 'value' => ';'],
            ['delimiter', 'string'],

            [['type_price', 'related_key_filter'], 'string'],

            ['file', 'file', 'skipOnEmpty' => false]
        ];
    }

    public function attributeLabels()
    {
        return [
            'delimiter' => 'Разделитель',
            'file' => 'Прайс-лист',
            'vendor_id' => 'Поставщик',
            'type_price' => 'Цена в прайсе',
            're' => 'Свойство по которому искать',
            'default_markup' => 'Наценка, если у товара отстуствует',
            'force_markup' => 'Принудительно проставить скидку',
        ];
    }

    public function getTypePrice()
    {
        return [
            self::TYPE_PRICE_BASE => 'Базовая цена',
            self::TYPE_PRICE_PURCHASE => 'Закупочная цена',
        ];
    }
}