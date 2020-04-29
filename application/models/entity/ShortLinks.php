<?php

namespace app\models\entity;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "short_links".
 *
 * @property int $id
 * @property string $name
 * @property int $visits
 * @property boolean $is_active
 * @property int $sort
 * @property string $link
 * @property string $short_code
 * @property int $created_at
 * @property int $updated_at
 */
class ShortLinks extends \yii\db\ActiveRecord
{
	/**
	 * {@inheritdoc}
	 */
	public static function tableName()
	{
		return 'short_links';
	}

	public function behaviors()
	{
		return [
			TimestampBehavior::className()
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function rules()
	{
		return [
			[['sort', 'visits', 'created_at', 'updated_at'], 'integer'],

			[['link', 'short_code'], 'required'],

			[['name', 'short_code'], 'string', 'max' => 255],

			[['link'], 'string'],

			['name', 'unique', 'targetClass' => ShortLinks::className()],

			[['is_active'], 'boolean'],

			['is_active', 'default', 'value' => true],
			['visits', 'default', 'value' => 0],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels()
	{
		return [
			'id' => 'ID',
			'name' => 'Название',
			'visits' => 'Переходы',
			'is_active' => 'Активность',
			'sort' => 'Порядок сортировки',
			'link' => 'Ссылка',
			'short_code' => 'Короткий код',
			'created_at' => 'Дата создания',
			'updated_at' => 'Дата обновления',
		];
	}
}
