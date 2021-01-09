<?php


namespace app\modules\promotion\models\forms;


use app\modules\promotion\models\entity\PromotionProductMechanics;

/**
 * This is the form "PromotionProductMechanicsForm".
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
class PromotionProductMechanicsForm extends PromotionProductMechanics
{
    public static function tableName()
    {
        return PromotionProductMechanics::tableName();
    }

    const MECH_PRODUCT_DISCOUNT = 1;
    const MECH_PAY_TO_PAY = 2;

    const DISCOUNT_RULE_PRICE = 1;
    const DISCOUNT_RULE_PERCENT = 2;

    public function getMechanics()
    {
        return [
            self::MECH_PRODUCT_DISCOUNT => 'Скидка на товар',
            self::MECH_PAY_TO_PAY => 'Нужно купить Х чтобы получить Х'
        ];
    }

    public function getDiscountRules()
    {
        return [
            self::DISCOUNT_RULE_PRICE => "Новая цена",
            self::DISCOUNT_RULE_PERCENT => "Процент",
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

    public function rules()
    {
        return [
            [['product_id', 'amount', 'promotion_mechanic_id', 'promotion_id'], 'integer'],
            [['discountRule'], 'string', 'max' => 255],
        ];
    }
}