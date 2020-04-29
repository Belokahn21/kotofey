<?php

namespace app\models\search;


use app\models\entity\support\Tickets;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class TicketSearchForm extends Tickets
{
	public static function tableName()
	{
		return "stocks";
	}

	public function rules()
	{
		return [
			[['id'], 'integer'],
			[['status'], 'string'],
		];
	}

	public function scenarios()
	{
		return Model::scenarios();
	}

	public function search($params)
	{
		$query = Tickets::find();

		$dataProvider = new ActiveDataProvider([
			'query' => $query,
		]);

		if (!($this->load($params) && $this->validate())) {
			return $dataProvider;
		}

		$query->andFilterWhere(['like', 'id', $this->id])
			->andFilterWhere(['like', 'status', $this->status]);

		return $dataProvider;
	}
}