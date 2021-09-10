<?php

namespace app\modules\catalog\models\helpers;

use app\modules\media\models\helpers\MediaHelper;
use app\modules\site\models\tools\Debug;
use app\modules\vendors\models\entity\Vendor;
use Yii;
use yii\helpers\Json;
use yii\helpers\Url;
use app\modules\site\models\tools\System;
use app\modules\media\models\entity\Media;
use app\modules\catalog\models\entity\Product;

class ProductHelper
{
    const COOKIE_VISITED_KEY = 'user_visited';

    public static function addVisitedItem($product_id)
    {
        $cookies = Yii::$app->response->cookies;

        $items = self::getAllVisitedItems();
        $items[] = $product_id;

        $cookies->add(new \yii\web\Cookie([
            'name' => self::COOKIE_VISITED_KEY,
            'value' => $items,
        ]));
    }

    public static function getAllVisitedItems()
    {
        $cookies = Yii::$app->request->cookies;
        return array_unique($cookies->getValue(self::COOKIE_VISITED_KEY, array()));
    }


    public static function getResultPrice(Product $model)
    {
        return ($model->getDiscountPrice() ? $model->getDiscountPrice() : $model->getPrice());
    }

    public static function getPercent(Product $model)
    {
        return $model->getDiscountPrice() ? 100 - round(($model->getDiscountPrice() * 100) / $model->getPrice()) : false;
    }

    public static function getMarkup(Product $model, int $default_value = 1)
    {
        $calc_value = intval(@round(($model->price / $model->purchase) * 100 - 100));
        return $calc_value > 0 ? $calc_value : $default_value;
    }

    public static function makePurchase(Product &$model, Vendor $vendor)
    {
        $model->purchase = intval($model->base_price - round($model->base_price * ($vendor->discount / 100)));
    }

    public static function setDiscount(Product &$model, $prcent)
    {
        $model->discount_price = $model->price - round($model->price * ($prcent / 100));
    }


    public static function applyMarkup(Product &$model, int $markup)
    {
        $model->price = intval(round($model->purchase + $model->purchase / 100 * $markup));
    }

    public static function purchaseVirtual(array $products)
    {
        $out = 0;
        /* @var $product Product */
        foreach ($products as $product) {
            $out += $product->count * $product->purchase;
        }

        return $out;
    }

    public static function profitVirtual(array $products)
    {
        $out = 0;
        /* @var $product Product */
        foreach ($products as $product) {
            $out += $product->count * $product->price;
        }

        return $out;
    }

    public static function getImageUrl(Product $model, $isFull = false, $options = [])
    {
        return MediaHelper::getImageUrl($model->media, $isFull, $options);
    }

    public static function getDetailUrl(Product $model, $isFull = false)
    {
        if ($isFull) return System::fullSiteUrl() . Url::to(['/catalog/product/view', 'id' => $model->slug]);

        return Url::to(['/catalog/product/view', 'id' => $model->slug]);
    }
}