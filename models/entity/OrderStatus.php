<?php

namespace app\models\entity;


use yii\behaviors\TimestampBehavior;
use yii\data\ActiveDataProvider;
use yii\db\ActiveRecord;

class OrderStatus extends ActiveRecord
{
	public static function tableName()
	{
		return "status_order";
	}

	public function rules()
	{
		return [
			['name', 'string'],
			['name', 'required', 'message' => '{attribute} должно быть заполнено'],
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
			'name' => "Название"
		];
	}
}