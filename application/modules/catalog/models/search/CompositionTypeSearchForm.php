<?php

namespace app\modules\catalog\models\search;

use app\modules\catalog\models\entity\CompositionType;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class CompositionTypeSearchForm extends CompositionType
{
    public static function tableName()
    {
        return CompositionType::tableName();
    }

    public function rules()
    {
        return [
            [['id'], 'integer'],
        ];
    }

    public function scenarios()
    {
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = CompositionType::find()->orderBy(['created_at' => SORT_DESC]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
        ]);


        return $dataProvider;
    }
}