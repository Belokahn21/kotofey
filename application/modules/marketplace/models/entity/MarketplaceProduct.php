<?php

namespace app\modules\marketplace\models\entity;

use Yii;
use app\modules\catalog\models\entity\Product;

/**
 * This is the model class for table "marketplace_product".
 *
 * @property int $id
 * @property int $product_id
 * @property int $marketplace_id
 *
 * @property Product $product
 */
class MarketplaceProduct extends \yii\db\ActiveRecord
{
    public function rules()
    {
        return [
            [['product_id', 'marketplace_id'], 'required'],
            [['product_id', 'marketplace_id'], 'integer'],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Product::className(), 'targetAttribute' => ['product_id' => 'id']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'product_id' => 'Product ID',
            'marketplace_id' => 'Marketplace ID',
        ];
    }

    public function getProduct()
    {
        return $this->hasOne(Product::className(), ['id' => 'product_id']);
    }
}
