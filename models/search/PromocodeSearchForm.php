<?php

namespace app\models\search;

use app\models\entity\Category;
use app\models\entity\Product;
use app\models\entity\Promo;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class PromocodeSearchForm extends Promo
{
    public static function tableName()
    {
        return "promo";
    }

    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['code'], 'string'],
        ];
    }

    public function scenarios()
    {
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = Promo::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'id', $this->id])
            ->andFilterWhere(['like', 'code', $this->code]);

        return $dataProvider;
    }
}