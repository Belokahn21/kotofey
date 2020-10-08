<?php

namespace app\modules\rbac\models\search;

use app\modules\catalog\models\entity\Product;
use app\modules\rbac\models\entity\AuthItem;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class AuthItemSearchForm extends AuthItem
{

    public static function tableName()
    {
        return "auth_item";
    }

    public function rules()
    {
        return [
            [['name'], 'string'],
            [['description'], 'string'],
        ];
    }

    public function scenarios()
    {
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = AuthItem::find()->where(['type' => AuthItem::TYPE_ROLE]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'description', $this->description]);

        return $dataProvider;
    }
}