<?php

namespace app\models\rbac;


use Yii;
use yii\db\ActiveRecord;

class AuthAssignment extends ActiveRecord
{
	public static function tableName()
	{
		return "auth_assignment";
	}

	public function addUserRole($role, $user)
	{
		$userRole = Yii::$app->authManager->getRole($role->name);
		Yii::$app->authManager->assign($userRole, $user->id);
		return true;
	}

	public function removeUserRoles($user_id)
	{
		return Yii::$app->authManager->revokeAll($user_id);
	}
}