<?php

namespace app\models\tool\import;


use app\modules\catalog\models\entity\Product;
use app\models\tool\Debug;

class Purina extends Importer
{
    public function getPricePath()
    {
        return \Yii::getAlias('@app/tmp/special_purina.csv');
    }

    public function update()
    {
        if (($handle = fopen($this->getPricePath(), "r")) !== false) {
            while (($line = fgetcsv($handle, 1000, ";")) !== false) {

                $code = $this->getActualCode($line);

                if (!is_numeric($code)) {
                    continue;
                }


                $price = round($line[3]);

                $product = Product::findOneByCode($code);

                if (!$product) {
                    $this->addEmptyCode($code);
                    continue;
                }

                $mark = $this->getOldPercent($product->price, $product->purchase);

                $product->purchase = $price;
                $product->price = $this->getNewPrice($price, $mark);
                $product->scenario = Product::SCENARIO_UPDATE_PRODUCT;
                $product->status_id = Product::STATUS_ACTIVE;


                if ($product->validate() && $product->update()) {
                    echo $product->name;
                    echo PHP_EOL;
                }

            }

            Debug::p($this->getBankNotFoundCodes());
        }
    }

    public function getActualCode($line)
    {
        if ($line[0] && $line[1]) {
            return $line[0] > $line[1] ? $line[0] : $line[1];
        }

        if (!$line[0] && $line[1]) {
            return $line[1];
        }

        return $line[1];
    }
}