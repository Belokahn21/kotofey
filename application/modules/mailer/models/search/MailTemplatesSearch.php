<?php

namespace app\modules\mailer\models\search;

use app\modules\mailer\models\entity\MailTemplates;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class MailTemplatesSearch extends MailTemplates
{
    public static function tableName()
    {
        return MailTemplates::tableName();
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
        $query = MailTemplates::find()->orderBy(['created_at' => SORT_DESC]);

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