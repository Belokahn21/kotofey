<?php

namespace app\models\tool\import;


use app\models\entity\Product;

class Tavela
{

    public function getPricePath()
    {
        return \Yii::getAlias('@app/tmp/price/tavela/tavela.csv');
    }

    public function update()
    {
        $empty_ids = [];
        if (($handle = fopen($this->getPricePath(), "r")) !== false) {
            while (($line = fgetcsv($handle, 1000, ";")) !== false) {


                $code = $line[12];
                $price = (int)$line[6];

                if (!is_numeric($code) or !is_numeric($price)) {
                    continue;
                }

                if ($product = Product::findOneByCode($code)) {
                    $product->scenario = Product::SCENARIO_UPDATE_PRODUCT;
                    $product->purchase = $price;
                    $product->price = $product->purchase + (ceil($product->purchase * 0.3));
                    $product->active = 1;

                    if (!$product->validate()) {
                        return false;
                    }

                    if (!$product->save()) {
                        return false;
                    }
                } else {
                    $empty_ids[] = $code;
                }

            }
        }


        echo "Не найдено товаров" . PHP_EOL;
        print_r($empty_ids);
        return true;
    }
}