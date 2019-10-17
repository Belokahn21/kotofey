<?php

namespace app\models\entity;


use mohorev\file\UploadBehavior;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

class Providers extends ActiveRecord
{
<<<<<<< HEAD
	const SCENARIO_INSERT = 'insert';
	const SCENARIO_UPDATE = 'update';

=======
>>>>>>> 9e707bd95789acd6c612a4f0df789f7632540aad
	public function rules()
	{
		return [
			[['name'], 'required'],

			[['name', 'notes', 'description'], 'string'],

<<<<<<< HEAD
			[['sort'], 'default', 'value' => 500],

=======
>>>>>>> 9e707bd95789acd6c612a4f0df789f7632540aad
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

<<<<<<< HEAD
	public function scenarios()
	{
		return [
			self::SCENARIO_INSERT => ['name', 'description', 'notes', 'active', 'sort'],
			self::SCENARIO_UPDATE => ['name', 'description', 'notes', 'active', 'sort'],
		];
	}

=======
>>>>>>> 9e707bd95789acd6c612a4f0df789f7632540aad
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