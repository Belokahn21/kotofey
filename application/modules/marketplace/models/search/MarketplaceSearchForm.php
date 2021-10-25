<?php

namespace app\modules\marketplace\models\search;

use app\modules\marketplace\models\entity\Marketplace;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class MarketplaceSearchForm extends Marketplace
{
    public static function tableName()
    {
        return Marketplace::tableName();
    }

    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['name'], 'string'],
        ];
    }

    public function scenarios()
    {
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = Marketplace::find()->orderBy(['id' => SORT_DESC]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'id', $this->id])
            ->andFilterWhere(['like', 'name', $this->name]);

        return $dataProvider;
    }
}