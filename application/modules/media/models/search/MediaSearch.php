<?php

namespace app\modules\media\models\search;

use app\modules\media\models\entity\Media;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class MediaSearch extends Media
{
    public static function tableName()
    {
        return Media::tableName();
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
        $query = Media::find()->orderBy(['created_at' => SORT_DESC]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere(['id' => $this->id]);

        return $dataProvider;
    }
}