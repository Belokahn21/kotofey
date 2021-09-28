<?php

namespace app\modules\catalog\models\search;


use app\modules\catalog\models\entity\Product;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\db\ActiveQuery;

class ProductSearchForm extends Product
{
    public $mixed_value;

    public static function tableName()
    {
        return Product::tableName();
    }

    public function rules()
    {
        return [
            ['id', 'each', 'rule' => ['integer']],
            [['count', 'price', 'purchase', 'category_id', 'prop_sales', 'status_id', 'vendor_id'], 'integer'],
            [['name', 'article', 'code', 'mixed_value', 'slug'], 'string'],
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


        if (!empty($this->mixed_value)) {
            $this->applySpecialFilter($query);
        } else {
            $query->andFilterWhere([
                'id' => $this->id,
                'category_id' => $this->category_id,
                'status_id' => $this->status_id,
                'article' => $this->article,
                'code' => $this->code,
                'slug' => $this->slug,
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
        return $dataProvider;
    }

    private function applySpecialFilter(ActiveQuery &$query)
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