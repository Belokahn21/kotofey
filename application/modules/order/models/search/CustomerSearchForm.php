<?php

namespace app\modules\order\models\search;

use app\modules\order\models\entity\Customer;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class CustomerSearchForm extends Customer
{
    public static function tableName()
    {
        return Customer::tableName();
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
        $query = Customer::find()->orderBy(['created_at' => SORT_DESC]);

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