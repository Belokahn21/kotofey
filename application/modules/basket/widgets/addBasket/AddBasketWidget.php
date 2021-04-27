<?php

namespace app\modules\basket\widgets\addBasket;


use app\modules\catalog\models\entity\Product;
use yii\base\Widget;
use app\modules\basket\models\entity\Basket;

/**
 * @property $product Product
 **/
class AddBasketWidget extends Widget
{
    public $product;
    public $count = 1;
    public $price;
    public $discount_price;
    public $discount = false;
    public $view = 'default';
    public $showOrderButton = false;

    public $showButton = true;
    public $showInfo = true;
    public $showControl = true;
    public $showOneClick = true;
    public $showPrice = false;

    public function run()
    {
        if (!$this->product instanceof Product) return false;

        if ($this->product->status_id == Product::STATUS_WAIT) return $this->render('wait', ['product' => $this->product, 'showOrderButton' => $this->showOrderButton]);

        if ($this->product->status_id == Product::STATUS_DRAFT) return $this->render('draft');

        $basket = Basket::findOne($this->product->id);

        return $this->render($this->view, [
            'basket' => $basket,
            'product_id' => $this->product->id,
            'count' => $this->count,
            'price' => $this->price,
            'discount_price' => $this->discount_price,
            'showButton' => $this->showButton,
            'showInfo' => $this->showInfo,
            'showControl' => $this->showControl,
            'showOneClick' => $this->showOneClick,
            'showPrice' => $this->showPrice,
            'discount' => $this->discount,
        ]);
    }
}