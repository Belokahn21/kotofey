<?php

namespace app\modules\catalog\models\entity;

/**
 * This is the model class for table "product_stock".
 *
 * @property int $id
 * @property int $product_id
 * @property int $stock_id
 * @property int $count
 */
class ProductStock extends \yii\db\ActiveRecord
{
    public function rules()
    {
        return [
            [['count'], 'default', 'value' => 0],

            [['stock_id'], 'required'],

            [['product_id', 'stock_id', 'count'], 'integer'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'product_id' => 'ID товара',
            'stock_id' => 'ID склада',
            'count' => 'Количество',
        ];
    }
}
