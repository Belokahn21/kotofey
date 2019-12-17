<?php

namespace app\models\entity;

use Yii;

/**
 * This is the model class for table "vaccination".
 *
 * @property int $id
 * @property integer $sort
 * @property integer $city_id
 * @property boolean $is_active
 * @property string $title
 * @property string $description
 * @property string $price
 * @property string $image
 * @property int $created_at
 * @property int $updated_at
 */
class Vaccination extends \yii\db\ActiveRecord
{
	/**
	 * {@inheritdoc}
	 */
	public static function tableName()
	{
		return 'vaccination';
	}

	/**
	 * {@inheritdoc}
	 */
	public function rules()
	{
		return [
			[['title'], 'required'],
			[['description'], 'string'],
			[['created_at', 'updated_at'], 'integer'],
			[['title', 'price', 'image'], 'string', 'max' => 255],

			[['sort', 'city_id'], 'integer'],
			[['sort'], 'default', 'value' => 500],

			[['is_active'], 'boolean'],
			[['is_active'], 'default', 'value' => true],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels()
	{
		return [
			'id' => 'ID',
			'city_id' => 'Город',
			'title' => 'Заголовок',
			'is_active' => 'Активность',
			'sort' => 'Порядок сортировки',
			'description' => 'Описание',
			'price' => 'Цена',
			'image' => 'Изображение',
			'created_at' => 'Дата создания',
			'updated_at' => 'Дата обновления',
		];
	}
}
