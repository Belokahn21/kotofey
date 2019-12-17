<?php

namespace app\models\search;


use app\models\entity\Vaccination;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class VaccinationSearchForm extends Vaccination
{

	public static function tableName()
	{
		return "vaccination";
	}

	public function rules()
	{
		return [
			[['title', 'price'], 'string'],
			[['sort', 'city_id'], 'integer'],
		];
	}

	public function scenarios()
	{
		return Model::scenarios();
	}

	public function search($params)
	{
		$query = Vaccination::find()->orderBy(['created_at' => SORT_DESC]);

		$dataProvider = new ActiveDataProvider([
			'query' => $query,
		]);

		if (!($this->load($params) && $this->validate())) {
			return $dataProvider;
		}

		$query->andFilterWhere(['like', 'title', $this->title])
			->andFilterWhere(['like', 'city_id', $this->city_id]);

		return $dataProvider;
	}
}