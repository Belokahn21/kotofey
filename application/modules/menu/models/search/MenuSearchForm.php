<?php


namespace app\modules\menu\models\search;


use app\modules\menu\models\entity\Menu;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class MenuSearchForm extends Menu
{

    public static function tableName()
    {
        return Menu::tableName();
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
        $query = Menu::find()->orderBy(['created_at' => SORT_DESC]);

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