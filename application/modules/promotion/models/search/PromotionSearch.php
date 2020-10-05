<?php
namespace app\modules\promotion\models\search;

use app\modules\promotion\models\entity\Promotion;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class PromotionSearch extends Promotion
{


    public static function tableName()
    {
        return "promotion";
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
        $query = Promotion::find()->orderBy(['created_at' => SORT_DESC]);

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