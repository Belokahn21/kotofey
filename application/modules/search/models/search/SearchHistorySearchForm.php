<?php

namespace app\modules\search\models\search;

use app\modules\search\models\entity\SearchQuery;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class SearchHistorySearchForm extends SearchQuery
{
    public static function tableName()
    {
        return SearchQuery::tableName();
    }

    public function rules()
    {
        return [
            [['text'], 'string'],
        ];
    }

    public function scenarios()
    {
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = SearchQuery::find()->orderBy(['created_at' => SORT_DESC]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'text', $this->text]);

        return $dataProvider;
    }
}