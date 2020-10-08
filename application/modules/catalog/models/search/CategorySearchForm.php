<?php

namespace app\modules\catalog\models\search;

use app\modules\catalog\models\entity\Category;
use app\modules\catalog\models\entity\Product;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class CategorySearchForm extends Category
{
    public static function tableName()
    {
        return "product_category";
    }

    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['name'], 'string'],
        ];
    }

    public function scenarios()
    {
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = Category::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'id', $this->id])
            ->andFilterWhere(['like', 'name', $this->name]);

        return $dataProvider;
    }
}