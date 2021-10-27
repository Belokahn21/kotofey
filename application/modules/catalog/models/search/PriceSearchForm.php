<?php

namespace app\modules\catalog\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\catalog\models\entity\Price;

class PriceSearchForm extends Price
{
    public static function tableName()
    {
        return Price::tableName();
    }

    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['name'], 'string'],
        ];
    }

    public function scenarios()
    {
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = Price::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'id', $this->id])
            ->andFilterWhere(['like', 'name', $this->name]);

        return $dataProvider;
    }
}