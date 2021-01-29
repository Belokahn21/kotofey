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
            [['id'], 'integer'],
            [['reason'], 'string'],
        ];
    }

    public function scenarios()
    {
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = ProductTransferHistory::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'id', $this->id])
            ->andFilterWhere(['like', 'reason', $this->reason]);

        return $dataProvider;
    }
}