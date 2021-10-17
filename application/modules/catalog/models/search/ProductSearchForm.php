<?php

namespace app\modules\catalog\models\search;


use app\modules\catalog\models\entity\Product;
use app\modules\promotion\models\entity\PromotionProductMechanics;
use app\modules\site\models\tools\Debug;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\db\ActiveQuery;
use yii\helpers\ArrayHelper;

class ProductSearchForm extends Product
{
    public $mixed_value;
    public $slug_;
    public $ar_id;
    public $with_discount;

    public static function tableName()
    {
        return Product::tableName();
    }

    public function rules()
    {
        return [
            ['ar_id', 'each', 'rule' => ['integer']],
            [['id', 'count', 'price', 'purchase', 'category_id', 'prop_sales', 'status_id', 'vendor_id', 'with_discount'], 'integer'],
            [['name', 'article', 'code', 'mixed_value', 'slug_'], 'string'],
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

        if ($this->with_discount == 1) {
            $available_promotions = PromotionProductMechanics::find()->joinWith('promotion')->andWhere([
                'or',
                'promotion.start_at = :default and promotion.end_at = :default',
                'promotion.start_at is null and promotion.end_at is null',
                'promotion.start_at < :now and promotion.end_at > :now'
            ])->andWhere(['promotion.is_active' => true])
                ->addParams([
                    ":now" => time(),
                    ":default" => 0,
                ])
                ->all();

            $query->andFilterWhere([
                'id' => ArrayHelper::getColumn($available_promotions, 'product_id')
            ]);
        } else {
            if (!empty($this->mixed_value)) {
                $this->applyMixedFilter($query);
            } else {
                $query->andFilterWhere([
                    'id' => $this->ar_id ? $this->ar_id : $this->id,
                    'category_id' => $this->category_id,
                    'status_id' => $this->status_id,
                    'article' => $this->article,
                    'code' => $this->code,
                    'slug' => $this->slug_,
                    'count' => $this->count,
                    'price' => $this->price,
                    'purchase' => $this->purchase,
                    'vendor_id' => $this->vendor_id,
                ]);

                if (!empty($this->name)) {
                    foreach (explode(' ', $this->name) as $text_line) {

                        $query->andFilterWhere([
                            'or',
                            ['like', 'name', $text_line],
                            ['like', 'feed', $text_line]
                        ]);
                    }
                }
            }
        }

        return $dataProvider;
    }

    private function applyMixedFilter(ActiveQuery &$query)
    {
        //check article
        $tmp_query = clone $query;
        $tmp_query->andFilterWhere([
            'article' => $this->mixed_value
        ]);

        if ($tmp_query->count() > 0) {
            $query->andFilterWhere([
                'article' => $this->mixed_value
            ]);
            return;
        }


        //check external_code
        $tmp_query = clone $query;
        $tmp_query->andFilterWhere([
            'code' => $this->mixed_value
        ]);

        if ($tmp_query->count() > 0) {
            $query->andFilterWhere([
                'code' => $this->mixed_value
            ]);
            return;
        }


        //check name
        foreach (explode(' ', $this->mixed_value) as $text_line) {
            $query->andFilterWhere([
                'or',
                ['like', 'name', $text_line],
                ['like', 'feed', $text_line]
            ]);
        }
    }
}