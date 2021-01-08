<?php

namespace app\modules\promotion\models\entity;

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
 */
class PromotionProductMechanics extends \yii\db\ActiveRecord
{
    const MECH_PRODUCT_DISCOUNT = 1;
    const MECH_PAY_TO_PAY = 2;

    public function getMechanics()
    {
        return [
            self::MECH_PRODUCT_DISCOUNT => 'Скидка на товар',
            self::MECH_PAY_TO_PAY => 'Нужно купить Х чтобы получить Х'
        ];
    }


    public function behaviors()
    {
        return [
            TimestampBehavior::className()
        ];
    }

    public function rules()
    {
        return [
            [['product_id'], 'required', 'when' => function ($model) {
                return $model->promotion_mechanic_id === self::MECH_PRODUCT_DISCOUNT;
            }],
            [['promotion_mechanic_id'], 'required'],
            [['product_id', 'amount', 'promotion_mechanic_id', 'promotion_id'], 'integer'],
            [['discountRule'], 'string', 'max' => 255],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'product_id' => 'Product ID',
            'promotion_id' => 'Promotion ID',
            'amount' => 'Amount',
            'discountRule' => 'Discount Rule',
            'promotion_mechanic_id' => 'Promotion Mechanic ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
