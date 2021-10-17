<?php

namespace app\modules\reviews\models\search;

use app\modules\reviews\models\entity\Reviews;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class ReviewsSearchForm extends Reviews
{

    public static function tableName()
    {
        return Reviews::tableName();
    }

    public function rules()
    {
        return [
            [['product_id','status_id'], 'integer'],
            [['text'], 'string'],
            [['is_active'], 'boolean'],
        ];
    }

    public function scenarios()
    {
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = Reviews::find()->orderBy(['created_at' => SORT_DESC]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'text', $this->text])
            ->andFilterWhere(['product_id' => $this->product_id])
            ->andFilterWhere(['status_id' => $this->status_id])
            ->andFilterWhere(['is_active' => $this->is_active]);

        return $dataProvider;
    }
}