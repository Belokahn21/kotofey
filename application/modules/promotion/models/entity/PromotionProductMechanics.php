<?php

namespace app\modules\promotion\models\entity;

use app\modules\catalog\models\entity\Product;
use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "promotion_product_mechanics".
 *
 * @property int $id
 * @property int $product_id
 * @property int|null $promotion_id
 * @property int|null $amount
 * @property string|null $discountRule
 * @property int|null $promotion_mechanic_id
 * @property int|null $created_at
 * @property int|null $updated_at
 *
 * @property Product $product
 */
class PromotionProductMechanics extends \yii\db\ActiveRecord
{
    public function behaviors()
    {
        return [
            TimestampBehavior::className()
        ];
    }

    public function getProduct()
    {
        return $this->hasOne(Product::className(), ['id' => 'product_id']);
    }

    public function getPromotion()
    {
        return $this->hasOne(Promotion::className(), ['id' => 'promotion_id']);
    }
}
