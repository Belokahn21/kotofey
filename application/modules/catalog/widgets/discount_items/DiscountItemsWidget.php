<?php

namespace app\modules\catalog\widgets\discount_items;


use app\modules\catalog\models\entity\Product;
use yii\base\Widget;

class DiscountItemsWidget extends Widget
{
    public $view = 'default';

    public function run()
    {
        $models = Product::find()->where(['>', 'discount_price', 0])->all();

        return $this->render($this->view, [
            'models' => $models
        ]);
    }
}