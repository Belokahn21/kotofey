<?php

namespace app\modules\vacancy\models\entity;

use mohorev\file\UploadBehavior;
use Yii;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "vaccination".
 *
 * @property int $id
 * @property integer $sort
 * @property integer $city_id
 * @property boolean $is_active
 * @property string $title
 * @property string $slug
 * @property string $description
 * @property string $price
 * @property string $image
 * @property int $created_at
 * @property int $updated_at
 */
class Vacancy extends \yii\db\ActiveRecord
{
	public function rules()
	{
		return [
			[['title'], 'required'],
			[['description', 'slug'], 'string'],
			[['created_at', 'updated_at'], 'integer'],
			[['title', 'price'], 'string', 'max' => 255],

			[['sort', 'city_id'], 'integer'],
			[['sort'], 'default', 'value' => 500],

			[['is_active'], 'boolean'],
			[['is_active'], 'default', 'value' => true],

			[['image'], 'file', 'skipOnEmpty' => true, 'extensions' => \Yii::$app->params['files']['extensions']],
		];
	}

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
			'slug' => 'Символьный код',
			'created_at' => 'Дата создания',
			'updated_at' => 'Дата обновления',
		];
	}

	public function behaviors()
	{
		return [
			TimestampBehavior::className(),
			[
				'class' => SluggableBehavior::className(),
				'attribute' => 'title',
				'ensureUnique' => true,
			],
			[
				'class' => UploadBehavior::class,
				'attribute' => 'image',
				'scenarios' => ['default'],
				'path' => '@webroot/upload/',
				'url' => '@web/upload/',
			],
		];
	}
}
