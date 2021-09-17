<?php

namespace app\modules\order\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\order\models\entity\CustomerStatus;

class CustomerStatusSearchForm extends CustomerStatus
{

    public static function tableName()
    {
        return CustomerStatus::tableName();
    }

    public function rules()
    {
        return [
        ];
    }

    public function scenarios()
    {
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = CustomerStatus::find()->orderBy(['created_at' => SORT_DESC]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

//        $query->andFilterWhere(['like', 'delivery_id', $this->delivery_id])
//            ->andFilterWhere(['user_id' => $this->user_id])
//            ->andFilterWhere(['phone' => $this->phone])
//            ->andFilterWhere(['email' => $this->email])
//            ->andFilterWhere(['id' => $this->id])
//            ->andFilterWhere(['ip' => $this->ip])
//            ->andFilterWhere(['is_paid' => $this->is_paid])
//            ->andFilterWhere(['status' => $this->status])
//            ->andFilterWhere(['like', 'payment_id', $this->payment_id]);

        return $dataProvider;
    }
}