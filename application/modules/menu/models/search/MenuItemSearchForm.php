<?php


namespace app\modules\menu\models\search;


use app\modules\menu\models\entity\Menu;
use app\modules\menu\models\entity\MenuItem;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class MenuItemSearchForm extends MenuItem
{

    public static function tableName()
    {
        return MenuItem::tableName();
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
        $query = MenuItem::find()->orderBy(['created_at' => SORT_DESC]);

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