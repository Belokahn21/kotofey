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
        $product_id = strval(\Yii::$app->request->get('product_id'));

        $product = Product::findOne($product_id);
        $ozon_prod = new OzonProduct();
        $ozon_prod->loadAttrs($product);

        if ($ozon_prod->validate()) {
            $ms = new MarketplaceService();
            $task_id = $ms->createProduct($ozon_prod);


        }
    }
}