<?php

namespace app\modules\marketplace\controllers;

use app\modules\catalog\models\entity\Product;
use app\modules\marketplace\models\entity\OzonProduct;
use app\modules\marketplace\models\services\MarketplaceService;
use yii\rest\Controller;

class RestBackendController extends Controller
{
    public function actionCreateProduct()
    {
        $ms = new MarketplaceService();
        $prod = new OzonProduct();
        $prod->loadAttrs(Product::findOne(1));
        $ms->createProduct($prod);

    }
}