<?php

namespace app\models\entity;


use mohorev\file\UploadBehavior;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

class Providers extends ActiveRecord
{
	public function rules()
	{
		return [
			[['name'], 'required'],

			[['name', 'notes', 'description'], 'string'],

			[['image'], 'file', 'extensions' => 'png, jpg, jpeg'],
		];
	}

	public function behaviors()
	{
		return [
			TimestampBehavior::className(),
			[
				'class' => UploadBehavior::class,
				'attribute' => 'image',
				'scenarios' => ['insert', 'update'],
				'path' => '@webroot/upload/{slug}',
				'url' => '@web/upload/{slug}',
			],
			[
				'class' => SluggableBehavior::class,
				'attribute' => 'name',
				'ensureUnique' => true,
			],
		];
	}

	public function attributeLabels()
	{
		return [
			'name' => 'Назание',
			'slug' => 'Символьный код',
			'description' => 'Описание',
			'notes' => 'Заметки',
			'link' => 'Ссылка',
			'active' => 'Активность',
			'image' => 'Картинка',
			'sort' => 'Сортировка',
		];
	}
}