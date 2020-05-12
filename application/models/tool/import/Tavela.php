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
        $not_found = [];
        if (($handle = fopen($this->getPricePath(), "r")) !== false) {
            while (($line = fgetcsv($handle, 1000, ";")) !== false) {
                $code = $line[12];
                if (!is_numeric($code)) {
                    continue;
                }

                if ($product = Product::findOneByCode($code)) {
                    echo $code . ' - ' . $product->name . PHP_EOL;
                } else {
                    $not_found[] = $code;
                }
            }
        }

        print_r($empty_ids);
        echo "Не найдено товаров" . PHP_EOL;
        print_r($not_found);
    }
}