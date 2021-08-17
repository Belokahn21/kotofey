<?php


namespace app\modules\catalog\models\helpers;

use app\modules\catalog\models\entity\PriceProduct;

class PriceHelper
{
    public static function getPriceByCode(int $product_id, string $code)
    {
        return \Yii::$app->cache->getOrSet('price-sale-product-' . $product_id . '-code-' . $code, function () use ($product_id, $code) {
            return PriceProduct::find()->where(['product_id' => $product_id, 'price.code' => $code])->leftJoin('price', 'price.id=price_id')->one();
        });
    }
}