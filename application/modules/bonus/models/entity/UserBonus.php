<?php

namespace app\modules\bonus\models\entity;


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

//	public static function findByUserId($userId)
//	{
//		return static::findOne(['user_id' => $userId]);
//	}

	public static function findByPhone($phone)
	{
		return static::findOne(['phone' => $phone]);
	}
}