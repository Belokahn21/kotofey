<?php

namespace app\modules\order\widgets\many_purchase;

use app\modules\catalog\models\entity\InformersValues;
use app\modules\catalog\models\entity\Product;
use app\modules\catalog\models\entity\ProductPropertiesValues;
use app\modules\order\models\entity\OrdersItems;
use yii\base\Widget;
use yii\helpers\ArrayHelper;

class ManyPurchasedGoods extends Widget
{
    public $view = 'default';
    public $cacheTime = 3600 * 24 * 7;

    public function run()
    {
        $informersValues = [];
        $cache = \Yii::$app->cache;
        $key = ManyPurchasedGoods::className();


        $products_in_orders = $cache->getOrSet('ManyPurchasedGoods-products_in_orders', function () {
            return OrdersItems::find()->select(['product_id'])->all();
        }, $this->cacheTime);

        if (!$products_in_orders) {
            return false;
        }

        $models = $cache->getOrSet('ManyPurchasedGoods-key', function () use ($products_in_orders) {
            return Product::find()->select(['id', 'name', 'price', 'discount_price', 'image', 'media_id'])->where(['status_id' => Product::STATUS_ACTIVE])->andWhere(['id' => ArrayHelper::getColumn($products_in_orders, 'product_id')])->all();
        }, $this->cacheTime);

        if (!$models) {
            return false;
        }

//        $arProductIds = ArrayHelper::getColumn($models, 'id');
//        $productPropertiesValues = ProductPropertiesValues::getDb()->cache(function () use ($arProductIds) {
//            return ProductPropertiesValues::find()->where(['product_id' => $arProductIds, 'property_id' => 1])->select(['value'])->groupBy('value')->all();
//        }, $this->cacheTime);
//
//        $values = ArrayHelper::getColumn($productPropertiesValues, 'value');
//        $informersValues = InformersValues::getDb()->cache(function () use ($values) {
//            return InformersValues::find()->where(['id' => $values])->all();
//        }, $this->cacheTime);

        return $this->render($this->view, [
            'models' => $models,
            'informersValues' => $informersValues,
        ]);
    }
}