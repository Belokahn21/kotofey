<?php

namespace app\models\entity;


use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * Promo model
 *
 * @property integer $id
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
        ];
    }

    public function attributeLabels()
    {
        return [
            'code' => "Символьный код",
            'discount' => "Скидка",
            'count' => "Количество",
        ];
    }

    public static function minusCode($code)
    {
        $promo = static::findByCode($code);
        if ($promo) {
            if ($promo->count - 1 > 0) {
                $promo->count = $promo->count - 1;
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
        return static::findOne(['code' => $code]);
    }
}