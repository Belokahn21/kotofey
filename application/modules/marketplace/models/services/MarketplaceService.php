<?php

namespace app\modules\marketplace\models\services;

use app\modules\catalog\models\repository\ProductRepository;
use app\modules\logger\models\service\LogService;
use app\modules\marketplace\models\api\OzonApi;
use app\modules\marketplace\models\entity\OzonProduct;
use app\modules\site\models\tools\Debug;
use yii\base\Model;
use yii\helpers\ArrayHelper;

class MarketplaceService extends Model
{
    public function createProduct(int $product_id)
    {
        $product = ProductRepository::getOne($product_id);
        $ozon_model = new OzonProduct();
        $ozon_model->loadAttrs($product);

        if (!$ozon_model->validate()) {
            $this->addErrors($ozon_model->getErrors());
            return false;
        }


        $ms = new OzonApi();
        $task_id = intval($ms->createProduct($ozon_model));

        if (!MarketplaceProductStatusService::addHistory($product, $task_id)) {
            $this->addError('history', 'Ошибка при добавлении истории внесения товара на маркетплейс.');
            return false;
        }


        return true;
    }

    public function updateStockCount(string $article, int $amount)
    {
        $result = false;
        $api = new OzonApi();
        $response = $api->updateCount($amount, $article);

        $_response = !is_array($response) ?: $response[0];


        if (ArrayHelper::getValue($_response, 'updated') == 1) {
            $result = true;
        } else {

            $_errs = [];
            $errors = ArrayHelper::getValue($_response, 'errors');
            foreach ($errors as $error) {
                $_errs[] = "[" . $error['code'] . "]: " . $error['message'];
            }

            LogService::saveErrorMessage(implode(PHP_EOL, $_errs), 'ozon');
        }

        return $result;
    }
}