<?php

namespace app\models\search;

use app\models\entity\News;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class NewsSearchForm extends News
{

    public static function tableName()
    {
        return "news";
    }

    public function rules()
    {
        return [
            [['title'], 'string'],
            [['description'], 'string'],
        ];
    }

    public function scenarios()
    {
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = News::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'description', $this->description]);

        return $dataProvider;
    }
}