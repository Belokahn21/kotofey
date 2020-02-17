<?php

namespace app\models\entity;


use app\models\entity\Discount;
use app\models\entity\User;
use app\models\entity\UserManagerScore;
use app\models\rbac\AuthItem;

/**
 * UserSeller model
 * @property UserManagerScore $score
 */
class UserSeller extends User
{
	public static function tableName()
	{
		return 'user';
	}

	public function getScore()
	{
		return UserManagerScore::find()->where(['user_id' => $this->id])->all();
	}
}