<?php

namespace app\modules\catalog\models\search;

use app\modules\catalog\models\entity\ProductCategory;
use app\modules\catalog\models\entity\Properties;
use app\modules\catalog\models\entity\SaveProductProperties;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class ProductPropertiesSearchForm extends Properties
{
    public static function tableName()
    {
        return Properties::tableName();
    }

    public function rules()
    {
        return [
            [['id', 'is_active'], 'integer'],
            [['name'], 'string'],
        ];
    }

    public function scenarios()
    {
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = Properties::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere(['id' => $this->id])
            ->andFilterWhere(['is_active' => $this->is_active])
            ->andFilterWhere(['like', 'name', $this->name]);

        return $dataProvider;
    }
}