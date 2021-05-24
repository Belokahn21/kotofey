<?php

namespace app\modules\order\models\search;

use app\modules\order\models\entity\CustomerProperties;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class CustomerPropertiesSearchForm extends CustomerProperties
{
    public static function tableName()
    {
        return CustomerProperties::tableName();
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
        $query = CustomerProperties::find()->orderBy(['created_at' => SORT_DESC]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere(['id' => $this->id]);

        return $dataProvider;
    }
}