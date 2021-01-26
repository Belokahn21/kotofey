<?php

namespace app\modules\catalog\models\search;

use app\modules\catalog\models\entity\PropertiesVariants;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class PropertiesVariantsSearchForm extends PropertiesVariants
{
    public static function tableName()
    {
        return PropertiesVariants::tableName();
    }

    public function rules()
    {
        return [
            [['id', 'property_id'], 'integer'],
            [['name'], 'string'],
        ];
    }

    public function scenarios()
    {
        return Model::scenarios();
    }


    public function search($params)
    {
        $query = PropertiesVariants::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['property_id' => $this->property_id])
            ->andFilterWhere(['id' => $this->id]);

        return $dataProvider;
    }

}