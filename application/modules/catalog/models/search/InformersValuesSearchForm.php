<?php

namespace app\modules\catalog\models\search;

use app\models\entity\InformersValues;
use app\models\rbac\AuthItem;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class InformersValuesSearchForm extends InformersValues
{

	public static function tableName()
	{
		return "informers_values";
	}

	public function rules()
	{
		return [
			[['informer_id', 'sort', 'id'], 'integer'],

			[['active'], 'boolean'],

			[['name', 'description'], 'string'],
		];
	}

	public function scenarios()
	{
		return Model::scenarios();
	}


	public function search($params)
	{
		$query = self::find();

		$dataProvider = new ActiveDataProvider([
			'query' => $query,
		]);

		if (!($this->load($params) && $this->validate())) {
			return $dataProvider;
		}

		$query->andFilterWhere(['like', 'name', $this->name])
			->andFilterWhere(['id' => $this->id])
			->andFilterWhere(['like', 'description', $this->description])
			->andFilterWhere(['active' => $this->active])
			->andFilterWhere(['informer_id' => $this->informer_id])
			->andFilterWhere(['sort' => $this->sort]);

		return $dataProvider;
	}

}