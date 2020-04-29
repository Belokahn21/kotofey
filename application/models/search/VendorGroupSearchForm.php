<?php

namespace app\models\search;

use app\models\entity\Providers;
use app\models\entity\Vendor;
use app\models\entity\VendorGroup;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class VendorGroupSearchForm extends VendorGroup
{

    public static function tableName()
    {
        return "vendor_group";
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
        $query = VendorGroup::find();

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