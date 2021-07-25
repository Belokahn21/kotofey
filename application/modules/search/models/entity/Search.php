<?php

namespace app\modules\search\models\entity;

use app\modules\catalog\models\entity\virtual\ProductElastic;
use app\modules\catalog\models\entity\Product;
use app\modules\search\models\services\SearchHistory\SearchHistory;
use app\modules\search\Module;
use app\modules\site\models\tools\Debug;
use yii\base\Model;
use yii\db\ActiveQuery;
use yii\helpers\ArrayHelper;

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
            $module = \Yii::$app->getModule('search');

            if ($module->search_engine == Module::SEARCH_ENGINE_ELASTIC) {
                try {
                    $elastic_ids = [-1];

                    $productElastics = ProductElastic::find()
                        ->query(['multi_match' => ['query' => $phrase, 'fields' => ['name', 'feed'], 'operator' => 'and']])
                        ->limit(10000)
                        ->all();


                    if ($productElastics) $elastic_ids = ArrayHelper::getColumn($productElastics, 'id');
                    if ($elastic_ids) $products->where(['id' => $elastic_ids]);


                } catch (\Exception $exception) {

                    if (is_numeric($phrase)) {
                        $products->where(['article' => $phrase]);
                    } else {
                        foreach (explode(' ', $phrase) as $text_line) {
                            $products->andFilterWhere([
                                'or',
                                ['like', 'name', $text_line],
                                ['like', 'feed', $text_line]
                            ]);
                        }
                    }
                }

            }
            if ($module->search_engine == Module::SEARCH_ENGINE_SITE) {
                if (is_numeric($phrase)) {
                    $products->where(['article' => $phrase]);
                } else {
                    foreach (explode(' ', $phrase) as $text_line) {
                        $products->andFilterWhere([
                            'or',
                            ['like', 'name', $text_line],
                            ['like', 'feed', $text_line]
                        ]);
                    }
                }
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

        $storage = new SearchHistory();
        $storage->save($phrase);

        return $products;

    }
}