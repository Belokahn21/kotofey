<?php

namespace app\modules\delivery\models\search;

use app\modules\delivery\models\entity\DeliveryService;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class DeliveryServiceSearchForm extends DeliveryService
{

    public static function tableName()
    {
        return DeliveryService::tableName();
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
        $query = DeliveryService::find()->orderBy(['created_at' => SORT_DESC]);

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