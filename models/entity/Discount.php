<?php

namespace app\models\entity;


use yii\db\ActiveRecord;

/**
 * Discount model
 *
 * @property integer $id
 * @property integer $user_id
 * @property float $count
 */
class Discount extends ActiveRecord
{
    public function rules()
    {
        return [
            [['count', 'user_id'], 'required', 'message' => '{attribute} поле должно быть заполнено'],
        ];
    }

    public static function findByUserId($userId)
    {
        return static::findOne(['user_id' => $userId]);
    }
}