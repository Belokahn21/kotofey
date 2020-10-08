<?php

namespace app\modules\catalog\models\helpers;

use app\models\tool\System;
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
        return floor((($model->price - $model->discount_price) / $model->price) * 100);
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

    public static function getImageUrl(Product $model, $isFull = false)
    {
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

    public static function getDetailUrl(Product $model)
    {
        return Url::to(['/catalog/product/view', 'id' => $model->slug]);
    }
}