<?php

namespace app\modules\marketplace\controllers;

use yii\rest\Controller;
use app\modules\marketplace\models\entity\OzonProduct;
use app\modules\catalog\models\repository\ProductRepository;
use app\modules\marketplace\models\services\MarketplaceService;
use app\modules\marketplace\models\services\MarketplaceProductStatusService;

class RestBackendController extends Controller
{
    public function actionCreateProduct()
    {
        $result = 200;
        $product_id = intval(\Yii::$app->request->get('product_id'));

        $product = ProductRepository::getOne($product_id);
        $ozon_model = new OzonProduct();
        $ozon_model->loadAttrs($product);

        if (!$ozon_model->validate()) {
            $result = 500;
        }


        $ms = new MarketplaceService();
        $task_id = intval($ms->createProduct($ozon_model));

        if (!MarketplaceProductStatusService::addHistory($product, $task_id)) $result = 500;

        return [
            'status' => $result,
            'message' => 'Успешно'
        ];
    }
}