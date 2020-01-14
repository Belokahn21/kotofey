<?php

namespace app\models\entity;


use app\models\tool\Debug;
use app\models\tool\Text;
use yii\base\Model;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

class Search extends Model
{
	public $search;
	public $category;
	public $pricefrom;
	public $priceto;

	public function rules()
	{
		return [
			[['search', 'category', 'pricefrom', 'priceto'], 'string']
		];
	}

	public function attributeLabels()
	{
		return [
			'search' => 'Название товара',
			'category' => 'Раздел',
			'pricefrom' => 'Цена от',
			'priceto' => 'Цена до',
		];
	}

	public function search()
	{
		$products = Product::find();
		$products = $this->setFilter($products);

		return $products->all();
	}

	public function setFilter(ActiveQuery $products)
	{
		if (!empty($this->search)) {

			$phrase = $this->search;
			$SearchQuery = new SearchQuery();
			$SearchQuery->text = $phrase;
			if (!\Yii::$app->user->isGuest) {
				$SearchQuery->user_id = \Yii::$app->user->id;
			}
			$words = explode(" ", $phrase);

			if (count($words) > 1) {

				foreach ($words as $word) {
					$products->andWhere(['like', 'name', $word]);
				}

			} else {
				$products->where(['like', 'name', $this->search]);
			}

		}

		$SearchQuery->count_find = $products->count();

		if ($SearchQuery->validate()) {
			$SearchQuery->save();
		}

		return $products;

	}


	private function formatSearchPhrase()
	{

	}
}