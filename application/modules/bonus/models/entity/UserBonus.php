<?php

namespace app\modules\bonus\models\entity;


use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * UserBonus model
 *
 * @property integer $id
 * @property integer $phone
 * @property float $count
 */
class UserBonus extends ActiveRecord
{
    const PERCENT_AFTER_SALE = 5;
    const REFERAL_COUNT_REWARD_MONEY = 200;

    public function rules()
    {
        return [
            [['count', 'phone'], 'required', 'message' => '{attribute} поле должно быть заполнено'],
        ];
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::className()
        ];
    }

    public function attributeLabels()
    {
        return [
            'phone' => 'Телефон-ID',
            'count' => 'Количество',
        ];
    }

    public static function findOneByPhone($phone)
    {
        return static::findOne(['phone' => $phone]);
    }
}