<?php

namespace app\modules\catalog\widgets\CatalogSliders\ManyPurchase;

use app\modules\catalog\models\entity\SaveInformersValues;
use app\modules\catalog\models\entity\Product;
use app\modules\catalog\models\entity\SaveProductPropertiesValues;
use app\modules\catalog\widgets\CatalogSliders\RenderSlider\RenderSliderWidget;
use app\modules\order\models\entity\OrdersItems;
use app\modules\site\models\tools\Debug;
use yii\base\Widget;
use yii\helpers\ArrayHelper;

class ManyPurchasedGoods extends Widget
{
    public $view = 'default';
    public $cacheTime = 3600 * 24 * 7;
    public $limit = 20;

    public function run()
    {
        $limit = $this->limit;

        $products_in_orders = \Yii::$app->cache->getOrSet('ManyPurchasedGoods-products_in_orders', function () {
            return OrdersItems::find()->select(['product_id'])->all();
        }, $this->cacheTime);

        if (!$products_in_orders) return false;

        $models = \Yii::$app->cache->getOrSet('ManyPurchasedGoods-key', function () use ($products_in_orders, $limit) {
            return Product::find()
                ->select(['id', 'name', 'price', 'discount_price', 'image', 'media_id', 'article', 'slug', 'status_id', 'description', 'images'])
                ->where(['status_id' => Product::STATUS_ACTIVE])
                ->andWhere(['id' => ArrayHelper::getColumn($products_in_orders, 'product_id')])
                ->andWhere(['<>', 'description', ''])
                ->andWhere(['<>', 'images', ''])
                ->orderBy(['created_at' => SORT_DESC])
                ->limit($limit)
                ->all();
        }, $this->cacheTime);

        if (!$models) return false;

        return RenderSliderWidget::widget(['models' => $models, 'title' => 'Выбор покупателей', 'view' => $this->view]);
    }
}