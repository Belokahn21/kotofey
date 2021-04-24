<?php

namespace app\modules\pets\models\search;

use app\modules\pets\models\entity\Pets;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class PetsSearchForm extends Pets
{
    public static function tableName()
    {
        return Pets::tableName();
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
        $query = Pets::find()->orderBy(['created_at' => SORT_DESC]);

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