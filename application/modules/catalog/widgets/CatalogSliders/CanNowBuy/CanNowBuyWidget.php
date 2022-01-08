<?php

namespace app\modules\catalog\widgets\CatalogSliders\CanNowBuy;


use app\modules\catalog\models\entity\Product;
use app\modules\catalog\widgets\CatalogSliders\RenderSlider\RenderSliderWidget;
use yii\base\Widget;

class CanNowBuyWidget extends Widget
{
    public $view = 'default';
    public $cacheTime = 3600 * 24 * 7;
    public $cacheKey = 'cannowbuywidget';
    public $limit = 20;

    public function run()
    {
        $limit = $this->limit;

        $models = \Yii::$app->cache->getOrSet($this->cacheKey, function () use ($limit) {
            return Product::find()
                ->select(['id', 'name', 'price', 'media_id', 'image', 'discount_price', 'article', 'count', 'slug', 'status_id'])
                ->where(['>', 'count', 0])
                ->limit($limit)
                ->andWhere(['status_id' => Product::STATUS_ACTIVE])
                ->all();
        }, $this->cacheTime);

        return RenderSliderWidget::widget([
            'models' => $models,
            'title' => 'Забирай сейчас!',
            'subTitle' => 'Доставка в течении часа!',
            'linkTitle' => 'Смотреть всё',
            'link' => '/catalog/?CatalogFilter[available]=Y',
        ]);
    }
}