<?php

namespace app\modules\geo\models\search;


use app\modules\geo\models\entity\Geo;
use app\modules\news\models\entity\News;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class GeoSearchForm extends Geo
{
	public static function tableName()
	{
		return Geo::tableName();
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