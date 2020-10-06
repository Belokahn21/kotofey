<?php

namespace app\models\tool\import;


use app\modules\catalog\models\entity\Product;
use yii\helpers\ArrayHelper;

class Forza10 extends Importer
{
    public function getPricePath()
    {
        return \Yii::getAlias('@app/tmp/forza.csv');
    }

    public function update()
    {
        $empty_ids = [];
        if (($handle = fopen($this->getPricePath(), "r")) !== false) {
            while (($line = fgetcsv($handle, 1000, ";")) !== false) {

                if (empty($line)) {
                    continue;
                }

                $name = null;
                if (array_key_exists('0', $line)) {
                    $name = $line[0];
                }

                $article = null;
                if (array_key_exists('2', $line)) {
                    $article = substr($line[2], 1, strlen($line[2]));
                }
                $price = null;
                if (array_key_exists('1', $line)) {
                    $price = $line[1];
                }

                if (!$article) {
                    continue;
                }

                if (!$product = Product::findOneByCode($article)) {
                    $this->addEmptyCode($article);
                }

                if ($product instanceof Product) {
                    echo $this->getOldPercent($product->price, $product->purchase);
                    echo PHP_EOL;
                }
            }
        }

        print_r($this->getBankNotFoundCodes());

//        print_r($empty_ids);
    }
}