<?php

namespace app\models\tool\import;


use app\modules\catalog\models\entity\Offers;
use app\modules\catalog\models\helpers\OfferHelper;

class Hills
{

    const VENDOR_ID = 5;

    public function getPricePath()
    {
        return \Yii::getAlias('@app/tmp/price/hills/hills.csv');
    }

    public function update($reCount = false)
    {
        $empty_ids = [];
        $counter = 0;
        if (($handle = fopen($this->getPricePath(), "r")) !== false) {
            while (($line = fgetcsv($handle, 1000, ";")) !== false) {

                $code = $line[2];
                $base = ceil(str_replace(' ', '', $line[5]));
                $purchase = ceil($base - ceil($base * 0.13));

                if (empty($code) or empty($purchase)) {
                    continue;
                }

                $oldPercent = null;

                if ($product = Offers::findOneByCode($code)) {

                    $percent = round(OfferHelper::getMarkup($product) / 100);

                    if ($product->discount_price) $oldPercent = OfferHelper::getPercent($product);

                    if (!$percent) $percent = 0.15;

                    $product->scenario = Offers::SCENARIO_UPDATE_PRODUCT;
                    $product->base_price = $base;
                    $product->purchase = $purchase;
                    $product->price = $product->purchase + ceil($product->purchase * $percent);

                    if ($oldPercent) OfferHelper::setDiscount($product, $oldPercent);

                    if (!$product->validate()) {
                        return false;
                    }

                    if ($product->update() === false) {
                        return false;
                    }

                    $counter++;

                } else {
                    $empty_ids[] = $code;
                }
            }
        }


        echo "Не найдено товаров" . PHP_EOL;
        print_r($empty_ids);
        echo "Пройдено по товарам" . PHP_EOL;
        print_r($counter);
        return true;
    }
}