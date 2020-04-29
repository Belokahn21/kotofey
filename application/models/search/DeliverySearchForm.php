<?php

namespace app\models\search;

use app\models\entity\Delivery;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class DeliverySearchForm extends Delivery
{
	public static function tableName()
	{
		return "delivery";
	}

	public function rules()
	{
		return [
			[['name'], 'string'],
		];
	}

	public function scenarios()
	{
		return Model::scenarios();
	}


	public function search($params)
	{
		$query = Delivery::find()->orderBy(['created_at' => SORT_DESC]);

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