<?php

namespace app\modules\catalog\models\search;


use app\modules\catalog\models\entity\Product;
use app\modules\catalog\models\entity\SaveProductProperties;
use app\modules\catalog\models\entity\SaveProductPropertiesValues;
use app\modules\site\models\tools\Debug;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;

class ProductSearchForm extends Product
{

    public static function tableName()
    {
        return Product::tableName();
    }

    public function rules()
    {
        return [
            [['id', 'count', 'price', 'purchase', 'category_id', 'prop_sales', 'status_id', 'vendor_id'], 'integer'],
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

//        exit();
//        $product_properties_values = [];
//        if ($this->prop_sales) {
//            $product_properties_values = ArrayHelper::getColumn(SaveProductPropertiesValues::find()->select(['product_id'])->where(['value' => $this->prop_sales, 'property_id' => 11])->all(), 'product_id');
//        }

//        if ($this->id) {
//            array_push($product_properties_values, $this->id);
//        }

        $query->andFilterWhere([
            'category_id' => $this->category_id,
            'status_id' => $this->status_id,
            'article' => $this->article,
            'code' => $this->code,
            'count' => $this->count,
            'price' => $this->price,
            'purchase' => $this->purchase,
            'vendor_id' => $this->vendor_id,
        ]);


//        if ($product_properties_values) {
//            $query->andFilterWhere([
//                'id' => $product_properties_values,
//            ]);
//        }

        if (!empty($this->name)) {
            foreach (explode(' ', $this->name) as $text_line) {
                $query->andFilterWhere([
                    'or',
                    ['like', 'name', $text_line],
                    ['like', 'feed', $text_line]
                ]);
            }
        }


        return $dataProvider;
    }
}