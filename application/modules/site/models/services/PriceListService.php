<?php


namespace app\modules\site\models\services;

use app\modules\catalog\models\entity\Product;
use app\modules\catalog\models\form\PriceUpdateForm;
use app\modules\catalog\models\helpers\ProductHelper;
use app\modules\site\models\tools\PriceTool;
use app\modules\vendors\models\entity\Vendor;

class PriceListService
{
    public function sortNotFound($all, $complete)
    {
        return array_udiff($all, $complete, function ($a, $b) {
            return $a->id - $b->id;
        });
    }

    public function normalize($type, $price): int
    {
        $result_price = 0;
        if ($type == PriceUpdateForm::TYPE_PRICE_BASE) {
            $result_price = PriceTool::normalize($price);
        }

        if ($type == PriceUpdateForm::TYPE_PRICE_PURCHASE) {
            $result_price = PriceTool::normalize($price);
        }

        return intval($result_price);
    }

    public function applyPrice(Product $product, $type_price, int $price, Vendor $vendor, int $default_markup, bool $force_markup)
    {
        $old_markup = ProductHelper::getMarkup($product, $default_markup);

        if ($force_markup) {
            $old_markup = $default_markup;
        }

        if ($type_price == PriceUpdateForm::TYPE_PRICE_BASE) {
            $product->base_price = $price;
            ProductHelper::makePurchase($product, $vendor);
            ProductHelper::applyMarkup($product, $old_markup);
        }

        if ($type_price == PriceUpdateForm::TYPE_PRICE_PURCHASE) {
            $product->purchase = $price;
            ProductHelper::applyMarkup($product, $old_markup);
        }
    }
}