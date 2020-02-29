<?php

namespace app\models\search;


use app\models\entity\Product;
use app\models\entity\ProductProperties;
use app\models\entity\ProductPropertiesValues;
use app\models\tool\Debug;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;

class ProductSearchForm extends Product
{

    public static function tableName()
    {
        return "product";
    }

    public function rules()
    {
        return [
            [['id', 'count', 'price', 'purchase', 'category_id', 'prop_sales'], 'integer'],
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

        $product_properties_values = null;
        if ($this->prop_sales) {
            $product_properties_values = ArrayHelper::getColumn(ProductPropertiesValues::find()->select(['product_id'])->where(['value' => $this->prop_sales, 'property_id' => 11])->all(), 'product_id');
        }

        $query->andFilterWhere([
            'id' => $product_properties_values,
            'category_id' => $this->category_id,
            'article' => $this->article,
            'code' => $this->code,
            'count' => $this->count,
            'price' => $this->price,
            'purchase' => $this->purchase,
        ]);

        if (!empty($this->name)) {
            $query->where(['like', 'name', $this->name]);
            $query->orWhere(['like', 'feed', $this->name]);

            if ($query->count() == 0) {
                $words = explode(" ", $this->name);
                if (count($words) > 1) {
                    foreach ($words as $word) {
                        $query->andWhere(['like', 'name', $word]);
                        $query->orWhere(['like', 'feed', $word]);
                    }
                }
            }
        }

        return $dataProvider;
    }
}