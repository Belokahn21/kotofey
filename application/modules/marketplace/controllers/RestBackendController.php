<?php

namespace app\modules\marketplace\controllers;

use app\modules\marketplace\models\services\MarketplaceService;
use yii\rest\Controller;

class RestBackendController extends Controller
{
    public function actionCreateProduct()
    {
        $result = 200;
        $product_id = intval(\Yii::$app->request->get('product_id'));

        $ms = new MarketplaceService();
        if (!$ms->createProduct($product_id)) {
            $ms->getErrors();
        }

        return [
            'status' => $result,
            'message' => 'Успешно'
        ];
    }

    public function actionRefreshCount()
    {

    }
}