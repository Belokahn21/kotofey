<?php


namespace app\modules\subscribe\models\search;


use app\modules\stock\models\entity\Stocks;
use app\modules\subscribe\models\entity\Subscribes;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class SubscribesSearch extends Subscribes
{
    public static function tableName()
    {
        return Subscribes::tableName();
    }

    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['email'], 'string'],
        ];
    }

    public function scenarios()
    {
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = Subscribes::find()->orderBy(['created_at' => SORT_DESC]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'id', $this->id])
            ->andFilterWhere(['like', 'email', $this->email]);

        return $dataProvider;
    }
}