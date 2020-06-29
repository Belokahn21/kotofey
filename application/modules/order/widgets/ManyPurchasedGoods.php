<?php

namespace app\modules\order\widgets;


use app\modules\catalog\models\entity\Product;
use app\modules\order\models\entity\OrdersItems;
use yii\base\Widget;
use yii\helpers\ArrayHelper;

class ManyPurchasedGoods extends Widget
{
    public $view = 'default';

    public function run()
    {
        $cache = \Yii::$app->cache;
        $key = ManyPurchasedGoods::className();

        $models = $cache->getOrSet($key, function () {
            $products_in_orders = OrdersItems::find()->select(['product_id'])->all();
            if (!$products_in_orders) {
                return false;
            }
            return Product::find()->where(['active' => true])->andWhere(['id' => ArrayHelper::getColumn($products_in_orders, 'product_id')])->all();
        });

        if (!$models) {
            return false;
        }

        return $this->render($this->view, [
            'models' => $models
        ]);
    }
}