<?php

namespace app\modules\vendors\models\search;

use app\modules\vendors\models\entity\Vendor;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class VendorSearchForm extends Vendor
{
    public static function tableName()
    {
        return Vendor::tableName();
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
        $query = Vendor::find();

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