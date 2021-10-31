<?php

namespace app\modules\marketplace\models\search;

use app\modules\mailer\models\entity\MailEvents;
use app\modules\marketplace\models\entity\Marketplace;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class MarketplaceSearch extends Marketplace
{
    public static function tableName()
    {
        return Marketplace::tableName();
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
        $query = Marketplace::find()->orderBy(['created_at' => SORT_DESC]);

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