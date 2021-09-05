<?php

namespace app\modules\catalog\models\search;

use app\modules\catalog\models\entity\CompositionProducts;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class CompositionProductSearchForm extends CompositionProducts
{
    public static function tableName()
    {
        return CompositionProducts::tableName();
    }

    public function rules()
    {
        return [
            [['id', 'product_id'], 'integer'],
        ];
    }

    public function scenarios()
    {
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = CompositionProducts::find()->orderBy(['created_at' => SORT_DESC]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'product_id' => $this->product_id,
        ]);


        return $dataProvider;
    }
}