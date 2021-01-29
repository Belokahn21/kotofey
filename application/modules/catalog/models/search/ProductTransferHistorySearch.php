<?php


namespace app\modules\catalog\models\search;


use app\modules\catalog\models\entity\ProductTransferHistory;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class ProductTransferHistorySearch extends ProductTransferHistory
{
    public static function tableName()
    {
        return ProductTransferHistory::tableName();
    }

    public function rules()
    {
        return [
            [['id', 'order_id', 'product_id'], 'integer'],
            [['reason'], 'string'],
        ];
    }

    public function scenarios()
    {
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = ProductTransferHistory::find()->orderBy(['created_at' => SORT_DESC]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere(['id' => $this->id])
            ->andFilterWhere(['order_id' => $this->order_id])
            ->andFilterWhere(['product_id' => $this->product_id])
            ->andFilterWhere(['like', 'reason', $this->reason]);

        return $dataProvider;
    }
}