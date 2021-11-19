<?php

namespace app\modules\marketplace\controllers;

use app\modules\logger\models\entity\Logger;
use app\modules\logger\models\service\LogService;
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
        $result = 200;
        $article = intval(\Yii::$app->request->post('article'));
        $amount = intval(\Yii::$app->request->post('amount'));

        if (empty($article) || empty($amount)) {
            LogService::saveErrorMessage("При обновлении остатков на Озон возникла ошибка. Не все параметры переданы в REST запросе. Article: $article, Amount: $amount", 'ozon');
            throw new \Exception('Not full send params');
        }

        $ms = new MarketplaceService();
        if (!$ms->updateStockCount($article, $amount)) {
            $ms->getErrors();
        }

        return [
            'status' => $result,
            'message' => 'Успешно'
        ];
    }
}