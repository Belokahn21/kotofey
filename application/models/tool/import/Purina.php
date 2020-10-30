<?php

namespace app\models\tool\import;


use app\modules\catalog\models\entity\Product;
use app\modules\site\models\tools\Debug;

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

                if (!$line[0] or !$line[1]) {
                    continue;
                }


                $price = round($line[3]);

                $product = $this->getActualProduct($line);

                if (!$product) {
                    $this->addEmptyCode($line[0]);
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

    public function getActualProduct($line)
    {
        if ($p1 = Product::findOneByCode($line[0])) {
            return $p1;
        }
        if ($p2 = Product::findOneByCode($line[1])) {
            return $p2;
        }

        return null;
    }
}