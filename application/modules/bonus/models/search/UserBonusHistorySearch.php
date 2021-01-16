<?php


namespace app\modules\bonus\models\search;

use app\modules\bonus\models\entity\UserBonusHistory;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class UserBonusHistorySearch extends UserBonusHistory
{
    public static function tableName()
    {
        return UserBonusHistory::tableName();
    }

    public function rules()
    {
        return [
            [['reason'], 'string'],
            [['count', 'bonus_account_id', 'order_id', 'is_active'], 'integer'],
        ];
    }

    public function scenarios()
    {
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = UserBonusHistory::find()->orderBy(['created_at' => SORT_DESC]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere(['count' => $this->count])
            ->andFilterWhere(['like', 'reason', $this->reason])
            ->andFilterWhere(['order_id' => $this->order_id])
            ->andFilterWhere(['is_active' => $this->is_active])
            ->andFilterWhere(['bonus_account_id' => $this->bonus_account_id]);

        return $dataProvider;
    }
}