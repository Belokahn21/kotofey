<?php

namespace app\modules\catalog\widgets\WhenCanBuy;


use yii\base\Widget;

class WhenCanBuyWidget extends Widget
{
    public $view = 'default';
    public $product;

    public function run()
    {
        return $this->render($this->view, [
            'product' => $this->product
        ]);
    }
}