<?php

namespace app\models\search;


use app\models\entity\Sliders;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class SlidersSearchForm extends Sliders
{
    public static function tableName()
    {
        return "sliders";
    }

    public function rules()
    {
        return [
            [['name'], 'string'],
            [['description'], 'string'],
        ];
    }

    public function scenarios()
    {
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = Sliders::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'description', $this->description]);

        return $dataProvider;
    }
}