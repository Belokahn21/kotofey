<?php

namespace app\models\tool\import;


use app\modules\catalog\models\entity\Product;
use yii\helpers\ArrayHelper;

class Forza10
{
    public function getPricePath()
    {
        return \Yii::getAlias('@app/tmp/price/forza/forza.csv');
    }

    public function update()
    {
        $empty_ids = [];
        if (($handle = fopen($this->getPricePath(), "r")) !== false) {
            while (($line = fgetcsv($handle, 1000, ";")) !== false) {

                if (empty($line)) {
                    continue;
                }

                if (array_key_exists('2', $line)) {
                    $name = $line[2];
                }
                if (array_key_exists('3', $line)) {
                    $article = $line[3];

                }
                if (array_key_exists('9', $line)) {
                    $price = $line[9];
                }


                if ($article) {
                    $product = Product::findOneByCode($article);
                    if ($product instanceof Product) {
                        $price = ceil($price);
                        if ($product->purchase !== $price) {
                            $current_price = ceil((($product->price - $product->purchase) / $product->purchase) * 100);

                            if ($price == 0) {
                                $empty_ids[] = $product->id;
                            } else {
                                $product->purchase = $price;
                                $product->price = $price + ceil($price * ($current_price / 100));
                                echo $article . '=' . $product->price . '=' . $current_price . '=' . $price . PHP_EOL;
                            }
                        }
                    }
                }
            }
        }

        print_r($empty_ids);
    }
}