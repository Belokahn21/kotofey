<?php

namespace app\models\helpers;


use app\models\entity\UserManagerScore;
use app\models\entity\UserSeller;

class PersonalHelper
{
	public static function issetScore($user_id)
	{
		return UserManagerScore::findOneByUserId($user_id) instanceof UserManagerScore;
	}

	public static function findAllManagers()
	{
		return UserSeller::find()->select('user.*, auth_assignment.*')->from(['user', 'auth_assignment'])->where('auth_assignment.user_id=user.id')->andWhere(['auth_assignment.item_name' => 'Saler'])->all();
	}
}