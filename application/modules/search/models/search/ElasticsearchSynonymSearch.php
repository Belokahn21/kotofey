<?php

namespace app\modules\search\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\search\models\entity\ElasticsearchSynonyms;

class ElasticsearchSynonymSearch extends ElasticsearchSynonyms
{

    public static function tableName()
    {
        return ElasticsearchSynonyms::tableName();
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
        $query = ElasticsearchSynonyms::find()->orderBy(['created_at' => SORT_DESC]);

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