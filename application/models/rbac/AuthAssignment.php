<?php

namespace app\models\rbac;


use Yii;
use yii\db\ActiveRecord;

/**
 * AuthAssignment model
 *
 * @property string $item_name
 * @property integer $user_id
 * @property integer $created_at
 */
class AuthAssignment extends ActiveRecord
{
	public static function tableName()
	{
		return "auth_assignment";
	}

	public function addUserRole($role, $user)
	{
		$userRole = Yii::$app->authManager->getRole($role);
		Yii::$app->authManager->assign($userRole, $user->id);
		return true;
	}

	public function removeUserRoles($user_id)
	{
		return Yii::$app->authManager->revokeAll($user_id);
	}
}