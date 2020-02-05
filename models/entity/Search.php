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
	public $save_history = false;

	public function rules()
	{
		return [
			[['search', 'category', 'pricefrom', 'priceto'], 'string'],

			[['save_history'], 'boolean'],
		];
	}

	public function attributeLabels()
	{
		return [
			'search' => 'Название товара',
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

			$products->where(['like', 'name', $phrase]);
			$products->orWhere(['like', 'feed', $phrase]);

			if ($products->count() == 0) {
				$words = explode(" ", $phrase);
				if (count($words) > 1) {
					foreach ($words as $word) {
						$products->andWhere(['like', 'name', $word]);
						$products->orWhere(['like', 'feed', $word]);
					}
				}
			}

		}


		if ($this->save_history == true) {

			$SearchQuery = new SearchQuery();
			$SearchQuery->text = $phrase;
			$SearchQuery->count_find = $products->count();

			if (!\Yii::$app->user->isGuest) {
				$SearchQuery->user_id = \Yii::$app->user->id;
			}

			if ($SearchQuery->validate()) {
				$SearchQuery->save();
			}
		}

		return $products;

	}
}