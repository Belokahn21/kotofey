<?php

namespace app\modules\order\widgets\many_purchase;

use app\modules\catalog\models\entity\SaveInformersValues;
use app\modules\catalog\models\entity\Product;
use app\modules\catalog\models\entity\SaveProductPropertiesValues;
use app\modules\order\models\entity\OrdersItems;
use app\modules\site\models\tools\Debug;
use yii\base\Widget;
use yii\helpers\ArrayHelper;

class ManyPurchasedGoods extends Widget
{
    public $view = 'default';
    public $cacheTime = 3600 * 24 * 7;

    public function run()
    {
        if (!Debug::isPageSpeed()) {
            $informersValues = [];
            $cache = \Yii::$app->cache;


            $products_in_orders = $cache->getOrSet('ManyPurchasedGoods-products_in_orders', function () {
                return OrdersItems::find()->select(['product_id'])->all();
            }, $this->cacheTime);

            if (!$products_in_orders) {
                return false;
            }

            $models = $cache->getOrSet('ManyPurchasedGoods-key', function () use ($products_in_orders) {
                return Product::find()->select(['id', 'name', 'price', 'discount_price', 'image', 'media_id', 'article', 'slug', 'status_id'])->where(['status_id' => Product::STATUS_ACTIVE])->andWhere(['id' => ArrayHelper::getColumn($products_in_orders, 'product_id')])->all();
            }, $this->cacheTime);

            if (!$models) {
                return false;
            }

            return $this->render($this->view, [
                'models' => $models,
                'informersValues' => $informersValues,
            ]);

        }
    }
}