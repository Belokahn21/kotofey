<?php

namespace app\modules\catalog\widgets\DiscountItems;


use app\modules\promotion\models\entity\PromotionProductMechanics;
use app\modules\site\models\tools\Debug;
use app\modules\catalog\models\entity\SaveInformersValues;
use app\modules\catalog\models\entity\Product;
use app\modules\catalog\models\entity\SaveProductPropertiesValues;
use yii\base\Widget;
use yii\helpers\ArrayHelper;

class DiscountItemsWidget extends Widget
{
    public $view = 'default';
    public $cacheTime = 3600 * 24 * 7;

    public function run()
    {
        if (!Debug::isPageSpeed()) {
            $cache = \Yii::$app->cache;
            $formatArray = array();

            $models = $cache->getOrSet('discountProducts', function () {
                return Product::find()->select(['id', 'name', 'price', 'media_id', 'image', 'discount_price', 'slug', 'article', 'status_id'])
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
                    ->all();
            }, $this->cacheTime);


            $formatArray = [];
//            foreach ($models as $model) {
//                $brand = $this->getBrandProperty($model->id);
//                $action = $this->getDiscountProperty($model->id);
//
//
//                if ($brand) {
//                    $formatArray['brands'][$brand['id']] = $brand;
//                }
//
//                if ($action) {
//                    $formatArray['actions'][$brand['id']][$action['id']] = $action;
//                }
//
//            }

            return $this->render($this->view, [
                'models' => $models,
                'formatArray' => $formatArray
            ]);

        }
    }

    public function getBrandProperty($product_id)
    {
        $cache = \Yii::$app->cache;
        $ProductPropertiesValues = $cache->getOrSet('brands-props-ProductPropertiesValues', function () use ($product_id) {
            return SaveProductPropertiesValues::find()->select(['value'])->where(['product_id' => $product_id, 'property_id' => 1])->all();
        }, $this->cacheTime);

        $InformerValues = $cache->getOrSet('brands-inf-ProductPropertiesValues', function () use ($ProductPropertiesValues) {
            return SaveInformersValues::find()->select(['informer_id', 'id', 'name'])->where(['id' => ArrayHelper::getColumn($ProductPropertiesValues, 'value')])->asArray(true)->one();
        }, $this->cacheTime);

        return $InformerValues;
    }

    public function getDiscountProperty($product_id)
    {
        $cache = \Yii::$app->cache;
        $ProductPropertiesValues = $cache->getOrSet('discount-props-ProductPropertiesValues', function () use ($product_id) {
            return SaveProductPropertiesValues::find()->select(['value'])->where(['product_id' => $product_id, 'property_id' => 11])->all();
        }, $this->cacheTime);

        $InformerValues = $cache->getOrSet('discount-inf-ProductPropertiesValues', function () use ($ProductPropertiesValues) {
            return SaveInformersValues::find()->select(['informer_id', 'id', 'name'])->where(['id' => ArrayHelper::getColumn($ProductPropertiesValues, 'value')])->asArray(true)->one();
        }, $this->cacheTime);

        return $InformerValues;
    }
}