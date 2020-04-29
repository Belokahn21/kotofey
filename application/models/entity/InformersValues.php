<?php

namespace app\models\entity;


use mohorev\file\UploadBehavior;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\data\ActiveDataProvider;
use yii\db\ActiveRecord;

/**
 * InformersValues model
 *
 * @property integer $id
 * @property boolean $active
 * @property integer $sort
 * @property integer $informer_id
 * @property string $name
 * @property string $link
 * @property string $description
 * @property string $image
 * @property integer $created_at
 * @property integer $updated_at
 */
class InformersValues extends ActiveRecord
{
	public function rules()
	{
		return [
			[['informer_id', 'name'], 'required', 'message' => 'Поле {attribute} обязательно'],

			[['informer_id', 'sort'], 'integer'],
			[['sort'], 'default', 'value' => 500],

			[['active'], 'boolean'],
			[['active'], 'default', 'value' => true],

			[['name', 'description', 'link'], 'string'],

			[['image'], 'file', 'skipOnEmpty' => true, 'extensions' => \Yii::$app->params['files']['extensions']],
		];
	}

	public function behaviors()
	{
		return [
			TimestampBehavior::className(),
			[
				'class' => SluggableBehavior::className(),
				'attribute' => 'name',
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

	public function attributeLabels()
	{
		return [
			'id' => 'ID',
			'informer_id' => 'Справочник',
			'name' => 'Название',
			'link' => 'Ссылка',
			'description' => 'Описание',
			'active' => 'Активность',
			'sort' => 'Сортировка',
			'image' => 'Картинка',
			'created_at' => 'Дата создания',
			'updated_at' => 'Дата обновления',
		];
	}
}