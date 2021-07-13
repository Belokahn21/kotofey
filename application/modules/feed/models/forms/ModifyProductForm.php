<?php

namespace app\modules\feed\models\forms;


use app\modules\catalog\models\entity\Offers;
use yii\base\Model;
use yii\db\ActiveQuery;

class ModifyProductForm extends Model
{
    public $feed;
    public $clear;

    public function rules()
    {
        return [
            ['feed', 'string'],
            ['clear', 'boolean'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'feed' => 'Поисковой контент',
            'clear' => 'Новый контент',
        ];
    }

    public function modify(ActiveQuery $products)
    {
        foreach ($products->all() as $product) {
            if ($this->clear) {
                $product->feed = $this->feed;
            } else {
                $product->feed .= $this->feed;
            }

            $product->scenario = Offers::SCENARIO_UPDATE_PRODUCT;
            if ($product->validate()) {
                if (!$product->save()) {
                    return false;
                }
            }
        }
        return true;
    }

    public function clearModel()
    {
        foreach ($this->getAttributes() as $key => $attribute) {
            $this{$key} = null;
        }
    }
}