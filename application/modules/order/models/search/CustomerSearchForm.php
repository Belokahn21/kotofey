<?php

namespace app\modules\order\models\search;

use app\modules\order\models\entity\Customer;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class CustomerSearchForm extends Customer
{
    public $mixed;

    public static function tableName()
    {
        return Customer::tableName();
    }

    public function rules()
    {
        return [
            ['mixed', 'safe'],
            [['phone'], 'integer'],
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

        if ($this->mixed) {
            if (is_numeric($this->mixed)) {
                $query->andFilterWhere(['phone' => $this->mixed]);
            } else {
                $query->andFilterWhere(['like', 'name', $this->mixed]);
            }
        } else {
            $query->andFilterWhere(['phone' => $this->phone]);
        }

        return $dataProvider;
    }
}