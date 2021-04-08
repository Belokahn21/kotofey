<?php


namespace app\modules\logger\models\search;


use app\modules\catalog\models\entity\Properties;
use app\modules\logger\models\entity\Logger;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class LoggerSearchForm extends Logger
{

    public static function tableName()
    {
        return Logger::tableName();
    }

    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['message', 'uniqCode'], 'string'],
        ];
    }

    public function scenarios()
    {
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = Logger::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere(['id' => $this->id])
            ->andFilterWhere(['like', 'message', $this->is_active])
            ->andFilterWhere(['like', 'uniqCode', $this->name]);

        return $dataProvider;
    }
}