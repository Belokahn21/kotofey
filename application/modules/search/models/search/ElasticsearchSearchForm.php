<?php

namespace app\modules\search\models\search;

use app\modules\catalog\models\entity\virtual\ProductElastic;
use yii\elasticsearch\ActiveDataProvider;

class ElasticsearchSearchForm extends ProductElastic
{
    public static function tableName()
    {
        return ProductElastic::tableName();
    }

    public function rules()
    {
        return [
            [['name'], 'string'],
        ];
    }

    public function scenarios()
    {
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = ProductElastic::find()->orderBy(['created_at' => SORT_DESC]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'name', $this->name]);

        return $dataProvider;
    }
}