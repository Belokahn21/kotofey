<?php

namespace app\models\search;


use app\models\entity\Geo;
use app\models\entity\News;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class GeoSearchForm extends Geo
{
	public static function tableName()
	{
		return "geo";
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
		$query = Geo::find()->orderBy(['created_at' => SORT_DESC]);

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