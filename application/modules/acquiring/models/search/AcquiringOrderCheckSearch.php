<?php


namespace app\modules\acquiring\models\search;

use app\modules\acquiring\models\entity\AcquiringOrderCheck;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class AcquiringOrderCheckSearch extends AcquiringOrderCheck
{

    public static function tableName()
    {
        return AcquiringOrderCheck::tableName();
    }

    public function rules()
    {
        return [
            [['id', 'order_id'], 'integer'],
            [['identifier_id'], 'string'],
        ];
    }

    public function scenarios()
    {
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = AcquiringOrderCheck::find()->orderBy(['created_at' => SORT_DESC]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere(['id' => $this->id])
            ->andFilterWhere(['order_id' => $this->order_id])
            ->andFilterWhere(['identifier_id' => $this->identifier_id]);

        return $dataProvider;
    }
}