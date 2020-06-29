<?php

namespace app\models\search;


use app\modules\payment\models\entity\Payment;
use app\models\rbac\AuthItem;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class PermissionsSearchForm extends AuthItem
{
    public static function tableName()
    {
        return "auth_item";
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
        $query = AuthItem::find()->where(['type' => AuthItem::TYPE_PERMISSION]);

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