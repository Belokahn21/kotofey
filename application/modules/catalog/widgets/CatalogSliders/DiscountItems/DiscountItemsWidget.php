<?php

namespace app\modules\catalog\widgets\CatalogSliders\DiscountItems;


use app\modules\catalog\widgets\CatalogSliders\RenderSlider\RenderSliderWidget;
use app\modules\promotion\models\entity\PromotionProductMechanics;
use app\modules\catalog\models\entity\Offers;
use yii\base\Widget;
use yii\helpers\ArrayHelper;

class DiscountItemsWidget extends Widget
{
    public $view = 'default';
    public $cacheTime = 3600 * 24 * 7;
    public $limit = 20;

    public function run()
    {
        $limit = $this->limit;

        $models = \Yii::$app->cache->getOrSet('discountProducts', function () use ($limit) {
            return Offers::find()->select(['id', 'name', 'price', 'media_id', 'image', 'discount_price', 'slug', 'article', 'status_id'])
                ->andWhere(['in', 'id', ArrayHelper::getColumn(PromotionProductMechanics::find()->joinWith('promotion')->andWhere([
                    'or',
                    'promotion.start_at = :default and promotion.end_at = :default',
                    'promotion.start_at is null and promotion.end_at is null',
                    'promotion.start_at < :now and promotion.end_at > :now'
                ])
                    ->addParams([
                        ":now" => time(),
                        ":default" => 0,
                    ])
                    ->all(), 'product_id')])
                ->limit($limit)
                ->all();
        }, $this->cacheTime);

        return RenderSliderWidget::widget([
            'models' => $models,
            'title' => 'Выгодные предложения',
        ]);
    }

//    public function getBrandProperty($product_id)
//    {
//        $cache = \Yii::$app->cache;
//        $ProductPropertiesValues = $cache->getOrSet('brands-props-ProductPropertiesValues', function () use ($product_id) {
//            return SaveProductPropertiesValues::find()->select(['value'])->where(['product_id' => $product_id, 'property_id' => 1])->all();
//        }, $this->cacheTime);
//
//        $InformerValues = $cache->getOrSet('brands-inf-ProductPropertiesValues', function () use ($ProductPropertiesValues) {
//            return SaveInformersValues::find()->select(['informer_id', 'id', 'name'])->where(['id' => ArrayHelper::getColumn($ProductPropertiesValues, 'value')])->asArray(true)->one();
//        }, $this->cacheTime);
//
//        return $InformerValues;
//    }
//
//    public function getDiscountProperty($product_id)
//    {
//        $cache = \Yii::$app->cache;
//        $ProductPropertiesValues = $cache->getOrSet('discount-props-ProductPropertiesValues', function () use ($product_id) {
//            return SaveProductPropertiesValues::find()->select(['value'])->where(['product_id' => $product_id, 'property_id' => 11])->all();
//        }, $this->cacheTime);
//
//        $InformerValues = $cache->getOrSet('discount-inf-ProductPropertiesValues', function () use ($ProductPropertiesValues) {
//            return SaveInformersValues::find()->select(['informer_id', 'id', 'name'])->where(['id' => ArrayHelper::getColumn($ProductPropertiesValues, 'value')])->asArray(true)->one();
//        }, $this->cacheTime);
//
//        return $InformerValues;
//    }
}