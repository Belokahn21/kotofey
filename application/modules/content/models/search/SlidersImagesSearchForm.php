<?php

namespace app\modules\content\models\search;

use app\modules\content\models\entity\SlidersImages;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class SlidersImagesSearchForm extends SlidersImages
{
    public static function tableName()
    {
        return "sliders_images";
    }

    public function rules()
    {
        return [
            [['text', 'description'], 'string'],
            [['slider_id'], 'string'],
        ];
    }

    public function scenarios()
    {
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = SlidersImages::find()->orderBy(['created_at' => SORT_DESC]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'text', $this->text])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['slider_id' => $this->slider_id]);

        return $dataProvider;
    }
}