<?php

namespace app\modules\feed\models\forms;


use app\models\entity\Product;
use yii\base\Model;

class SearchProductForm extends Model
{
    public $name;
    public $feed;


    public function attributeLabels()
    {
        return [
            'name' => 'Название товаров',
            'feed' => 'Поисковой контент',
        ];
    }

    public function rules()
    {
        return [
            [['name', 'feed'], 'string'],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function search()
    {
        $products = Product::find();

        foreach (explode(' ', $this->name) as $text_line) {
            $products->andFilterWhere(['or',
                ['like', 'name', $text_line],
                ['like', 'feed', $text_line]
            ]);
        }

        return $products;
    }
}