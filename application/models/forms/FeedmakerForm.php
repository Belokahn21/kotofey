<?php

namespace app\models\forms;


use yii\base\Model;

class FeedmakerForm extends Model
{
	public $attribute;
	public $feed;
	public $name;
	public $update;

	public function rules()
	{
		return [
			[['feed', 'name'], 'string'],

			[['attribute'], 'integer'],

			[['update'], 'boolean'],
		];
	}

	public function attributeLabels()
	{
		return [
			'attribute' => 'Производитель',
			'feed' => 'Контент поиска',
			'update' => 'Новый контент',
		];
	}
}