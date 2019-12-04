<?php

namespace app\models\entity;


use yii\behaviors\TimestampBehavior;
use yii\data\ActiveDataProvider;
use yii\db\ActiveRecord;

class Delivery extends ActiveRecord
{
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

	public function createDelivery()
	{
		if ($this->load(\Yii::$app->request->post())) {
			if ($this->validate()) {
				return $this->save();
			}
		}
	}

	public function search($params)
	{
		$query = static::find();

		$dataProvider = new ActiveDataProvider([
			'query' => $query,
		]);

		if (!($this->load($params) && $this->validate())) {
			return $dataProvider;
		}

		$query->andFilterWhere(['like', 'name', $this->name]);

		return $dataProvider;
	}
}