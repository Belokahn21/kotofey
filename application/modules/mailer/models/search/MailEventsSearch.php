<?php


namespace app\modules\mailer\models\search;


use app\modules\mailer\models\entity\MailEvents;
use app\modules\menu\models\entity\Menu;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class MailEventsSearch extends MailEvents
{
    public static function tableName()
    {
        return MailEvents::tableName();
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
        $query = MailEvents::find()->orderBy(['created_at' => SORT_DESC]);

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