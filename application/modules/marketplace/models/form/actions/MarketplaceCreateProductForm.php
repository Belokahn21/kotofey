<?php

namespace app\modules\marketplace\models\form\actions;

use yii\base\Model;

class MarketplaceCreateProductForm extends Model
{
    public $product_id;

    public function attributeLabels()
    {
        return [
            'product_id' => 'Товар'
        ];
    }

    public function rules()
    {
        return [
            [['product_id'], 'integer'],
            [['product_id'], 'required'],
        ];
    }
}