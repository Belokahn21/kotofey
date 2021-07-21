<?php

namespace app\modules\promocode\models\search;

use app\modules\promocode\models\entity\Promocode;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class PromocodeSearchForm extends Promocode
{
	public static function tableName()
	{
		return Promocode::tableName();
	}

	public function rules()
	{
		return [
			[['id'], 'integer'],
			[['code'], 'string'],
		];
	}

	public function scenarios()
	{
		return Model::scenarios();
	}

	public function search($params)
	{
		$query = Promocode::find();

		$dataProvider = new ActiveDataProvider([
			'query' => $query,
		]);

		if (!($this->load($params) && $this->validate())) {
			return $dataProvider;
		}

		$query->andFilterWhere(['like', 'id', $this->id])
			->andFilterWhere(['like', 'code', $this->code]);

		return $dataProvider;
	}
}