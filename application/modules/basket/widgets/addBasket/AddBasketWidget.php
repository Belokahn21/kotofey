<?php

namespace app\modules\basket\widgets\addBasket;


use yii\base\Widget;
use app\modules\basket\models\entity\Basket;

class AddBasketWidget extends Widget
{
    public $product_id;
    public $count = 1;
    public $price;
    public $view = 'default';

    public $showButton = true;
    public $showInfo = true;
    public $showControl = true;
    public $showOneClick = true;

    public function run()
    {
        if (empty($this->product_id) or empty($this->price)) {
            return false;
        }

        $basket = Basket::findOne($this->product_id);

        return $this->render($this->view, [
            'basket' => $basket,
            'product_id' => $this->product_id,
            'count' => $this->count,
            'price' => $this->price,
            'showButton' => $this->showButton,
            'showInfo' => $this->showInfo,
            'showControl' => $this->showControl,
            'showOneClick' => $this->showOneClick,
        ]);
    }
}