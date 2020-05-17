<?php

namespace app\models\search;

use app\modules\delivery\models\entity\Delivery;
use app\models\entity\Payment;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class PaymentSearchForm extends Payment
{
    public static function tableName()
    {
        return "payment";
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
        $query = Payment::find();

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