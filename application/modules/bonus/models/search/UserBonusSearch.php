<?php


namespace app\modules\bonus\models\search;


use app\modules\bonus\models\entity\UserBonus;
use app\modules\bonus\models\entity\UserBonusHistory;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class UserBonusSearch extends UserBonus
{

    public static function tableName()
    {
        return UserBonus::tableName();
    }

    public function rules()
    {
        return [
            [['count', 'phone'], 'integer'],
        ];
    }

    public function scenarios()
    {
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = UserBonus::find()->orderBy(['created_at' => SORT_DESC]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere(['count' => $this->count])
            ->andFilterWhere(['phone' => $this->phone]);

        return $dataProvider;
    }
}