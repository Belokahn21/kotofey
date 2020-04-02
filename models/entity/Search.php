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

		return $products;
	}

	public function setFilter(ActiveQuery $products)
	{
		if (!empty($this->search)) {

			$phrase = $this->search;

            foreach (explode(' ', $phrase) as $text_line) {
                $products->andFilterWhere(['or',
                    ['like', 'name', $text_line],
                    ['like', 'feed', $text_line]
                ]);
            }


		}


		if ($this->save_history == true) {

			$SearchQuery = new SearchQuery();
			$SearchQuery->text = $phrase;
			$SearchQuery->count_find = $products->count();
			$SearchQuery->ip = $_SERVER['REMOTE_ADDR'];

			if (!\Yii::$app->user->isGuest) {
				$SearchQuery->user_id = \Yii::$app->user->id;
			}

			if ($SearchQuery->validate()) {
				$SearchQuery->save();
			}
		}

		$products->andWhere(['active' => 1]);

		return $products;

	}
}