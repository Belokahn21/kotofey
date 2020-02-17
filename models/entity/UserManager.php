<?php

namespace app\models\entity;

use Yii;

/**
 * This is the model class for table "user_manager".
 *
 * @property int $id
 * @property int $user_id
 * @property int $manager_id
 * @property int $created_at
 * @property int $updated_at
 */
class UserManager extends \yii\db\ActiveRecord
{
	/**
	 * {@inheritdoc}
	 */
	public static function tableName()
	{
		return 'user_manager';
	}

	/**
	 * {@inheritdoc}
	 */
	public function rules()
	{
		return [
			[['user_id', 'manager_id', 'created_at', 'updated_at'], 'integer'],
			[['user_id'], 'unique'],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels()
	{
		return [
			'id' => 'ID',
			'user_id' => 'User ID',
			'manager_id' => 'Manager ID',
			'created_at' => 'Created At',
			'updated_at' => 'Updated At',
		];
	}

	public static function findOneByUserId($user_id)
	{
		return static::findOne(['user_id' => $user_id]);
	}
}
