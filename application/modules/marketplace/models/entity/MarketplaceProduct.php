<?php

namespace app\modules\marketplace\models\entity;

use app\modules\catalog\models\entity\Product;
use Yii;

/**
 * This is the model class for table "marketplace_product".
 *
 * @property int $id
 * @property int $marketplace_id
 * @property int $product_id
 *
 * @property Marketplace $marketplace
 * @property Product $product
 */
class MarketplaceProduct extends \yii\db\ActiveRecord
{
    public function rules()
    {
        return [
            [['marketplace_id', 'product_id'], 'required'],

            [['marketplace_id', 'product_id'], 'integer'],

            [['marketplace_id'], 'exist', 'skipOnError' => true, 'targetClass' => Marketplace::className(), 'targetAttribute' => ['marketplace_id' => 'id']],

            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Product::className(), 'targetAttribute' => ['product_id' => 'id']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'marketplace_id' => 'Площадка',
            'product_id' => 'Товар',
        ];
    }

    public function getMarketplace()
    {
        return $this->hasOne(Marketplace::className(), ['id' => 'marketplace_id']);
    }

    public function getProduct()
    {
        return $this->hasOne(Product::className(), ['id' => 'product_id']);
    }
}
