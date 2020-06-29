<?php

namespace app\modules\search\models\entity;

use app\modules\user\models\entity\User;
use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "search_query".
 *
 * @property int $id
 * @property string $text
 * @property int $user_id
 * @property int $count_find
 * @property string $ip
 * @property int $created_at
 * @property int $updated_at
 *
 * @property User $user
 */
class SearchQuery extends \yii\db\ActiveRecord
{
	/**
	 * {@inheritdoc}
	 */
	public static function tableName()
	{
		return 'search_query';
	}

	/**
	 * {@inheritdoc}
	 */
	public function rules()
	{
		return [
			[['text'], 'required'],
			[['text', 'ip'], 'string'],
			[['user_id', 'created_at', 'updated_at', 'count_find'], 'integer'],
		];
	}

	public function behaviors()
	{
		return [
			TimestampBehavior::className(),
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels()
	{
		return [
			'id' => 'ID',
			'text' => 'Поисковая фраза',
			'user_id' => 'User ID',
			'ip' => 'IP адрес',
			'count_find' => 'Количество найденых товаров',
			'created_at' => 'Дата создания',
			'updated_at' => 'Дата обновления',
		];
	}

	public function getUser()
	{
		return User::findOne($this->user_id);
	}
}
