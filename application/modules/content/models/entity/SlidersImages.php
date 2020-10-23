<?php

namespace app\modules\content\models\entity;

use app\modules\content\models\behaviors\DateToIntBehaviors;
use app\modules\media\components\behaviors\ImageUploadMinify;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * SlidersImages model
 *
 * @property integer $id
 * @property integer $slider_id
 * @property integer $sort
 * @property boolean $active
 * @property string $image
 * @property string $text
 * @property string $description
 * @property string $link
 * @property integer $start_at
 * @property integer $end_at
 * @property integer $created_at
 * @property integer $updated_at
 */
class SlidersImages extends ActiveRecord
{
	public static function tableName()
	{
		return "sliders_images";
	}

	public function behaviors()
	{
		return [
			DateToIntBehaviors::className(),
			TimestampBehavior::class,
			[
				'class' => ImageUploadMinify::class,
				'attribute' => 'image',
				'scenarios' => ['default'],
				'path' => '@webroot/upload/',
				'url' => '@web/upload/',
			],
		];
	}

	public function rules()
	{
		return [
			[['sort'], 'default', 'value' => 500],

			[['active'], 'default', 'value' => 1],

			[['slider_id'], 'required'],
			[['slider_id', 'sort', 'active'], 'integer'],

			[['link', 'text', 'description'], 'string'],

			[['end_at', 'start_at'], 'safe'],

			[['image'], 'file', 'skipOnEmpty' => true, 'extensions' => \Yii::$app->params['files']['extensions']],
		];
	}

	public function attributeLabels()
	{
		return [
			'text' => 'Название',
			'description' => 'Описание',
			'slider_id' => 'Слайдер',
			'image' => 'Картинка',
			'active' => 'Активность',
			'sort' => 'Сортировка',
			'link' => 'Ссылка',
			'start_at' => 'Начало показа',
			'end_at' => 'Конец показа',
		];
	}
}