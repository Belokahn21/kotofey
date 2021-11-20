<?php

namespace app\modules\marketplace\models\services;

use app\modules\catalog\models\repository\ProductRepository;
use app\modules\marketplace\models\api\OzonApi;
use app\modules\marketplace\models\entity\OzonProduct;
use app\modules\site\models\tools\Debug;
use yii\base\Model;

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
        $api = new OzonApi();
        $result = $api->updateCount($amount, $article);
        return $result;
    }
}