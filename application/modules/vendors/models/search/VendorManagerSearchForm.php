<?php

namespace app\modules\vendors\models\search;

use app\modules\vendors\models\entity\VendorManager;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class VendorManagerSearchForm extends VendorManager
{

    public static function tableName()
    {
        return VendorManager::tableName();
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
        $query = VendorManager::find();

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