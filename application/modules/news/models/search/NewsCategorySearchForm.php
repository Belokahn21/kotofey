<?php

namespace app\modules\news\models\search;

use app\modules\news\models\entity\NewsCategory;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class NewsCategorySearchForm extends NewsCategory
{

    public static function tableName()
    {
        return "news_category";
    }

    public function rules()
    {
        return [
            [['name'], 'string'],
            [['category'], 'string'],
        ];
    }

    public function scenarios()
    {
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = NewsCategory::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'category', $this->category]);

        return $dataProvider;
    }
}