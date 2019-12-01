<?php

namespace app\models\search;


use app\models\entity\Product;
use app\models\entity\ProductProperties;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class ProductSearchForm extends Product
{
	public static function tableName()
	{
		return "product";
	}

	public function rules()
	{
		return [
			[['id', 'count', 'price', 'purchase', 'category'], 'integer'],
			[['name', 'article', 'code'], 'string'],
		];
	}

	public function scenarios()
	{
		return Model::scenarios();
	}

	public function search($params)
	{
		$query = Product::find()->orderBy(['created_at' => SORT_DESC]);

		$dataProvider = new ActiveDataProvider([
			'query' => $query,
		]);

		if (!($this->load($params) && $this->validate())) {
			return $dataProvider;
		}

		$query->andFilterWhere(['like', 'id', $this->id])
			->andFilterWhere(['like', 'category', $this->category])
			->andFilterWhere(['like', 'article', $this->article])
			->andFilterWhere(['like', 'code', $this->code])
			->andFilterWhere(['like', 'count', $this->count])
			->andFilterWhere(['like', 'count', $this->count])
			->andFilterWhere(['like', 'price', $this->price])
			->andFilterWhere(['like', 'purchase', $this->purchase])
			->andFilterWhere(['like', 'name', $this->name]);

		return $dataProvider;
	}
}