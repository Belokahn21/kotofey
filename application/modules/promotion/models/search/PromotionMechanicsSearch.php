<?php

namespace app\modules\promotion\models\search;

use app\modules\promotion\models\entity\PromotionProductMechanics;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class PromotionMechanicsSearch extends PromotionProductMechanics
{
    public static function tableName()
    {
        return PromotionProductMechanics::tableName();
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
        $query = PromotionProductMechanics::find()->orderBy(['created_at' => SORT_DESC]);

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