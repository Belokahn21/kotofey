<?php

namespace app\modules\search\models\entity;


use app\modules\search\models\entity\SearchQuery;
use app\modules\catalog\models\entity\Product;
use yii\base\Model;
use yii\db\ActiveQuery;

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
            $products->andWhere(['active' => 1]);

            $phrase = $this->search;

            foreach (explode(' ', $phrase) as $text_line) {
                $products->andFilterWhere([
                    'or',
                    ['like', 'name', $text_line],
                    ['like', 'feed', $text_line]
                ]);
            }


        }


        if ($this->save_history == true && \Yii::$app->user->id !== 1) {

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

        return $products;

    }
}