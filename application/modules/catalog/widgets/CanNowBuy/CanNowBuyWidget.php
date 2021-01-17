<?php

namespace app\modules\catalog\widgets\CanNowBuy;


use app\modules\catalog\models\entity\Product;
use yii\base\Widget;

class CanNowBuyWidget extends Widget
{
    public $view = 'default';
    public $cacheTime = 3600 * 24 * 7;
    public $cacheKey = 'cannowbuywidget';

    public function run()
    {
        $models = \Yii::$app->cache->getOrSet($this->cacheKey, function () {
            return Product::find()->select(['id', 'name', 'price', 'media_id', 'image', 'discount_price', 'article', 'count', 'slug', 'status_id'])->where(['>', 'count', 0])->andWhere(['status_id' => Product::STATUS_ACTIVE])->all();
        }, $this->cacheTime);

        return $this->render($this->view, [
            'models' => $models
        ]);
    }
}