<?php

namespace app\modules\catalog\models\search;

use app\modules\catalog\models\entity\Category;
use app\modules\catalog\models\entity\SaveInformers;
use app\modules\catalog\models\entity\Product;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class SaveInformersSearchForm extends SaveInformers
{
	public static function tableName()
	{
		return SaveInformers::tableName();
	}

	public function rules()
	{
		return [
			[['id', 'is_show_filter', 'is_active'], 'integer'],
			[['name'], 'string'],
		];
	}

	public function scenarios()
	{
		return Model::scenarios();
	}

	public function search($params)
	{
		$query = SaveInformers::find();

		$dataProvider = new ActiveDataProvider([
			'query' => $query,
		]);

		if (!($this->load($params) && $this->validate())) {
			return $dataProvider;
		}

		$query->andFilterWhere(['like', 'id', $this->id])
			->andFilterWhere(['like', 'is_active', $this->is_show_filter])
			->andFilterWhere(['like', 'is_show_filter', $this->is_show_filter])
			->andFilterWhere(['like', 'name', $this->name]);

		return $dataProvider;
	}
}