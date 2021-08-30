<?php

namespace app\modules\pets\models\search;

use app\modules\pets\models\entity\Breed;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class BreedSearchForm extends Breed
{

    public static function tableName()
    {
        return Breed::tableName();
    }

    public function rules()
    {
        return [
            [['name', 'size'], 'string'],
            [['animal_id'], 'integer'],
        ];
    }

    public function scenarios()
    {
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = Breed::find()->orderBy(['created_at' => SORT_DESC]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['size' => $this->size])
            ->andFilterWhere(['animal_id' => $this->animal_id]);

        return $dataProvider;
    }
}