<?php

namespace app\modules\catalog\models\entity;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "price_product".
 *
 * @property int $id
 * @property int|null $price_id
 * @property int|null $product_id
 * @property int|null $value
 * @property int|null $created_at
 * @property int|null $updated_at
 *
 * @property Price $price
 */
class PriceProduct extends \yii\db\ActiveRecord
{
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    public function rules()
    {
        return [
            [['price_id', 'product_id', 'value', 'created_at', 'updated_at'], 'integer'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'price_id' => 'Price ID',
            'product_id' => 'Product ID',
            'value' => 'Value',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public function getPrice()
    {
        return $this->hasOne(Price::className(), ['id' => 'price_id']);
    }
}
