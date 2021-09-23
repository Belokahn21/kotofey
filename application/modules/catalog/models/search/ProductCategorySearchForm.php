<?php

namespace app\modules\catalog\models\search;

use app\modules\catalog\models\entity\ProductCategory;
use app\modules\catalog\models\entity\Product;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class ProductCategorySearchForm extends ProductCategory
{
    public static function tableName()
    {
        return ProductCategory::tableName();
    }

    public function rules()
    {
        return [
            [['id', 'parent_category_id'], 'integer'],
            [['name'], 'string'],
        ];
    }

    public function scenarios()
    {
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = ProductCategory::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'id', $this->id])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['parent_category_id' => $this->parent_category_id]);

        return $dataProvider;
    }
}