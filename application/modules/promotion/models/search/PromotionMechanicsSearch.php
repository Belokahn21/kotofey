<?php

namespace app\modules\promotion\models\search;

use app\modules\promotion\models\entity\Promotion;
use app\modules\promotion\models\entity\PromotionMechanics;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class PromotionMechanicsSearch extends Promotion
{
    public static function tableName()
    {
        return "promotion_mechanics";
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
        $query = PromotionMechanics::find()->orderBy(['created_at' => SORT_DESC]);

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