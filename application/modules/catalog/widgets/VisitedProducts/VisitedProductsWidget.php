<?php

namespace app\modules\catalog\widgets\VisitedProducts;


use app\modules\catalog\models\entity\Product;
use app\modules\catalog\models\helpers\ProductHelper;
use app\modules\site\models\tools\Debug;
use yii\base\Widget;

class VisitedProductsWidget extends Widget
{
    public $view = 'default';
    public $limit = 10;

    public function run()
    {
        $products = Product::find()->andWhere(['id' => ProductHelper::getAllVisitedItems()]);


        if ($this->limit) $products->limit($this->limit);


        $products = $products->all();
        return $this->render($this->view, [
            'products' => $products
        ]);
    }
}