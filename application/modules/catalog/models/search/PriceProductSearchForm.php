<?php

namespace app\modules\catalog\models\search;

use app\modules\catalog\models\entity\Price;
use app\modules\catalog\models\entity\PriceProduct;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class PriceProductSearchForm extends PriceProduct
{

    public static function tableName()
    {
        return Price::tableName();
    }

    public function rules()
    {
        return [
            [['id', 'product_id', 'price_id'], 'integer'],
        ];
    }

    public function scenarios()
    {
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = PriceProduct::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere(['id' => $this->id])
            ->andFilterWhere(['product_id' => $this->product_id])
            ->andFilterWhere(['price_id' => $this->price_id]);

        return $dataProvider;
    }
}