<?php

namespace app\modules\catalog\models\helpers;

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

    /* цена товара за 1 киллограмм */
    public static function getPriceByWeight(Product $product, $weight)
    {
        $product_weight = PropertiesHelper::getProductWeight($product->id);
        if (!$product_weight) {
            return false;
        }

        $price_by_one_position_weight = round($product->price / $product_weight);
        $summary_price = round($price_by_one_position_weight * ($weight / 1000));

        return $summary_price;
    }

    public static function getResultPrice(Product $model)
    {
        return ($model->getDiscountPrice() ? $model->getDiscountPrice() : $model->getPrice());
    }

    public static function getPercent(Product $model)
    {
        return $model->getDiscountPrice() ? 100 - round(($model->getDiscountPrice() * 100) / $model->getPrice()) : false;
    }

    public static function getMarkup(Product $model)
    {
        return @round(($model->price / $model->purchase) * 100 - 100);
    }

    public static function makePurchase(Product &$model, Vendor $vendor)
    {
        $model->purchase = $model->base_price - round($model->base_price * ($vendor->discount / 100));
    }

    private static function getPercentTwoNums($big, $small)
    {
        return round(($big / $small) * 100 - 100);
    }

    public static function setDiscount(Product &$model, $prcent)
    {
        $model->discount_price = $model->price - round($model->price * ($prcent / 100));
    }


    public static function applyMarkup(Product &$model, $markup)
    {
        $model->price = round($model->purchase + $model->purchase / 100 * $markup);
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
        if ($media = $model->media) {
            if ($media->location == Media::LOCATION_CDN) {

                if ($options) return \Yii::$app->CDN->resizeImage($model->media->cdnData['public_id'], $options);

                return $media->cdnData['secure_url'];
            }
            $url = "/upload/" . $media->name;
            $noImage = "/upload/images/not-image.png";

            if (empty($model->image)) $url = $noImage;


            if (!is_file(\Yii::getAlias('@webroot/upload/' . $media->name))) $url = $noImage;

            if ($isFull) return System::fullSiteUrl() . $url;

            return $url;
        }

        // for old engine
        $url = "/upload/" . $model->image;
        $noImage = "/upload/images/not-image.png";

        if (empty($model->image)) {
            $url = $noImage;
        }

        if (!is_file(\Yii::getAlias('@webroot/upload/' . $model->image))) $url = $noImage;


        if ($isFull) return System::fullSiteUrl() . $url;

        return $url;
    }

    public static function getDetailUrl(Product $model, $isFull = false)
    {
        if ($isFull) return System::fullSiteUrl() . Url::to(['/catalog/product/view', 'id' => $model->slug]);

        return Url::to(['/catalog/product/view', 'id' => $model->slug]);
    }

    public static function getGalleryImages(Product $model)
    {
        $out = [];
        if ($model->images) {
            foreach (Json::decode($model->images) as $image) {
                $out[] = $image;
            }
        }
        return $out;
    }
}