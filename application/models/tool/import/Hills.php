<?php

namespace app\models\tool\import;


use app\models\entity\Product;

class Hills
{

    const VENDOR_ID = 5;

    public function getPricePath()
    {
        return \Yii::getAlias('@app/tmp/price/hills/hills2020.csv');
    }

    public function update()
    {
        $empty_ids = [];
        $counter = 0;
        if (($handle = fopen($this->getPricePath(), "r")) !== false) {
            while (($line = fgetcsv($handle, 1000, ";")) !== false) {

                $code = $line[2];
                $base = ceil(str_replace(' ', '', $line[6]));
                $purchase = ceil($base - ceil($base * 0.13));

                if (empty($code) or empty($purchase)) {
                    continue;
                }


                if ($product = Product::findOneByCode($code)) {

                    $percent = ($product->price - $product->purchase) / $product->price;
                    $percent = $percent + 0.1;

                    $product->scenario = Product::SCENARIO_UPDATE_PRODUCT;
                    $product->base_price = $base;
                    $product->purchase = $purchase;
                    $product->price = $product->purchase + ceil($product->purchase * $percent);

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