<?php

namespace app\models\entity;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "user_manager_score".
 *
 * @property int $id
 * @property int $user_id
 * @property int $score
 * @property int $created_at
 * @property int $updated_at
 */
class UserManagerScore extends \yii\db\ActiveRecord
{
	public function behaviors()
	{
		return [
			TimestampBehavior::className()
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public static function tableName()
	{
		return 'user_manager_score';
	}

	/**
	 * {@inheritdoc}
	 */
	public function rules()
	{
		return [
			[['user_id'], 'required'],
			[['user_id', 'score', 'created_at', 'updated_at'], 'integer'],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels()
	{
		return [
			'id' => 'ID',
			'user_id' => 'ID пользователя',
			'score' => 'Счёт',
			'created_at' => 'Дата создания',
			'updated_at' => 'Дата обновления',
		];
	}

	public static function findOneByUserId($user_id)
	{
		return static::findOne(['user_id' => $user_id]);
	}
}
