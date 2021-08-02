<?php

namespace app\modules\mailer\models\search;

use app\modules\mailer\models\entity\MailEvents;
use app\modules\mailer\models\entity\MailHistory;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class MailHistorySearch extends MailHistory
{
    public static function tableName()
    {
        return MailHistory::tableName();
    }

    public function rules()
    {
        return [
            [['mail_template_id'], 'integer'],
        ];
    }

    public function scenarios()
    {
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = MailHistory::find()->orderBy(['created_at' => SORT_DESC]);

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