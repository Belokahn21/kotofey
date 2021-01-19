<?php

namespace app\modules\catalog\models\search;


use app\modules\catalog\models\entity\ProductCategory;
use app\modules\catalog\models\entity\PropertyGroup;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class PropertiesGroupSearchForm extends PropertyGroup
{

    public static function tableName()
    {
        return PropertyGroup::tableName();
    }

    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['name'], 'string'],
        ];
    }

    public function scenarios()
    {
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = PropertyGroup::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'id', $this->id])
            ->andFilterWhere(['like', 'name', $this->name]);

        return $dataProvider;
    }
}