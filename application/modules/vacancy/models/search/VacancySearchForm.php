<?php

namespace app\modules\vacancy\models\search;


use app\models\entity\Vacancy;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class VacancySearchForm extends Vacancy
{

	public static function tableName()
	{
		return "vacancy";
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
		$query = Vacancy::find()->orderBy(['created_at' => SORT_DESC]);

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