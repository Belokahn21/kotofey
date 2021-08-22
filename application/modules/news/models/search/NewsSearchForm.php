<?php

namespace app\modules\news\models\search;

use app\modules\news\models\entity\News;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class NewsSearchForm extends News
{

    public static function tableName()
    {
        return News::tableName();
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
        $query = News::find()->orderBy(['created_at' => SORT_DESC]);

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