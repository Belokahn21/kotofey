<?php

namespace app\modules\catalog\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\catalog\models\entity\Product;

class ProductSearchForm extends Product
{

    public static function tableName()
    {
        return Product::tableName();
    }

    public function rules()
    {
        return [
            [['id'], 'integer'],
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

        $query->andFilterWhere([
            'id' => $this->id,
        ]);


        return $dataProvider;
    }
}