<?php

namespace app\modules\catalog\models\helpers;

use app\models\tool\System;
use app\modules\media\models\entity\Media;
use app\modules\site\models\tools\Debug;
use yii\helpers\Url;
use app\modules\catalog\models\helpers\ProductPropertiesHelper;
use app\modules\catalog\models\entity\Product;

class ProductHelper
{
    /* цена товара за 1 киллограмм */
    public static function getPriceByWeight(Product $product, $weight)
    {
        $product_weight = ProductPropertiesHelper::getProductWeight($product->id);
        $summary_price = 0;
        if (!$product_weight) {
            return false;
        }

        $price_by_one_position_weight = round($product->price / $product_weight);
        $summary_price = round($price_by_one_position_weight * ($weight / 1000));

        return $summary_price;
    }

    public static function getResultPrice(Product $model)
    {
        return ($model->discount_price ? $model->discount_price : $model->price);
    }

    public static function getPercent(Product $model)
    {
        return @round(($model->price / $model->discount_price) * 100) - 100;
    }

    public static function getMarkup(Product $model)
    {
        return @round(($model->price / $model->purchase) * 100) - 100;
    }

    public static function setDiscount(Product &$model, $prcent)
    {
        $model->discount_price = $model->price - round($model->price * ($prcent / 100));
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

        if (Debug::isPageSpeed()) {
            return '/images/not-image.png';
        }

        if ($media = $model->media) {
            if ($media->location == Media::LOCATION_CDN) {

                if ($options) {
                    return \Yii::$app->CDN->resizeImage($model->media->cdnData['public_id'], $options);
                }

                return $media->cdnData['secure_url'];
            }
            $url = "/upload/" . $media->name;
            $noImage = "/upload/images/not-image.png";

            if (empty($model->image)) {
                $url = $noImage;
            }

            if (!is_file(\Yii::getAlias('@webroot/upload/' . $media->name))) {
                $url = $noImage;
            }


            if ($isFull) {
                return System::fullDomain() . $url;
            }

            return $url;
        }

        // for old engine
        $url = "/upload/" . $model->image;
        $noImage = "/upload/images/not-image.png";

        if (empty($model->image)) {
            $url = $noImage;
        }

        if (!is_file(\Yii::getAlias('@webroot/upload/' . $model->image))) {
            $url = $noImage;
        }


        if ($isFull) {
            return System::fullDomain() . $url;
        }

        return $url;
    }

    public static function getDetailUrl(Product $model, $isFull = false)
    {
        if ($isFull)
            return System::fullDomain() . Url::to(['/catalog/product/view', 'id' => $model->slug]);

        return Url::to(['/catalog/product/view', 'id' => $model->slug]);
    }
}