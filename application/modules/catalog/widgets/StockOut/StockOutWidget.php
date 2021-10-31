<?php

namespace app\modules\catalog\widgets\StockOut;


use app\modules\catalog\models\entity\Product;
use app\modules\catalog\models\repository\ProductRepository;
use yii\base\Widget;

class StockOutWidget extends Widget
{
    public $view = 'default';

    public function run()
    {
        $products = ProductRepository::getStockOut();
        return $this->render($this->view, [
            'products' => $products
        ]);
    }
}