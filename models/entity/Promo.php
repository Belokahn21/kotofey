<?php

namespace app\models\entity;


use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * Promo model
 *
 * @property integer $id
 * @property integer $is_active
 * @property string $code
 * @property integer $discount
 * @property integer $count
 * @property integer $created_at
 * @property integer $updated_at
 */
class Promo extends ActiveRecord
{
    public function behaviors()
    {
        return [
            TimestampBehavior::className()
        ];
    }

    public function rules()
    {
        return [
            [['code', 'discount', 'count'], 'required', 'message' => '{attribute} должно заполнить'],

            [['code'], 'string'],

            [['discount', 'count'], 'integer'],

            [['is_active'], 'boolean'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'code' => "Символьный код",
            'discount' => "Скидка",
            'count' => "Количество",
            'is_active' => "Активность",
        ];
    }

    public static function minusCode($code)
    {
        $promo = static::findByCode($code);
        if ($promo) {
            if ($promo->count - 1 > 0) {
                $promo->count = $promo->count - 1;
            } else {
                $promo->is_active = false;
            }

            return $promo->update();
        }
        return false;
    }

    public static function clear()
    {
        unset($_SESSION['promobasket']);
    }

    public static function findByCode($code)
    {
        return static::findOne(['code' => $code, 'is_active' => true]);
    }
}