<?php

namespace app\models\search;


use app\models\entity\Geo;
use app\models\entity\GeoTimezone;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class GeoTimezoneSearch extends GeoTimezone
{

    public static function tableName()
    {
        return "geo_timezone";
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
        $query = GeoTimezone::find()->orderBy(['created_at' => SORT_DESC]);

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