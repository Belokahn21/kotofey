<?php

namespace app\modules\delivery\models\entity;


use yii\behaviors\TimestampBehavior;
use yii\data\ActiveDataProvider;
use yii\db\ActiveRecord;

class Delivery extends ActiveRecord
{
	const LIMIT_ORDER_SUMM_TO_ACTIVATE = 500;
	const PRICE_DELIVERY = 100;

	public function rules()
	{
		return [
			['name', 'required', 'message' => '{attribute} должно быть заполнено'],

			['description', 'string'],

			['active', 'boolean'],
		];
	}

	public function behaviors()
	{
		return [
			TimestampBehavior::className()
		];
	}

	public function attributeLabels()
	{
		return [
			'id' => "ID",
			'name' => "Нвазвание",
			'description' => "Описаниие",
			'active' => "Активность",
		];
	}

	public function getNameF()
	{
		return $this->name . " (" . ($this->active == 1 ? 'Активен' : 'Не активен') . ")";
	}
}