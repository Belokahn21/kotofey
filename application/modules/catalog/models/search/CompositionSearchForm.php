<?php

namespace app\modules\catalog\models\search;


use app\modules\catalog\models\entity\Composition;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class CompositionSearchForm extends Composition
{
    public static function tableName()
    {
        return Composition::tableName();
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
        $query = Composition::find()->orderBy(['created_at' => SORT_DESC]);

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