<?php

namespace app\models\tool\import;


use app\modules\catalog\models\entity\Product;
use yii\helpers\ArrayHelper;

class Forza10 extends Importer
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


                if (!$article) {
                    continue;
                }

                if (!$product = Product::findOneByCode($article)) {
                    $this->addEmptyCode($article);
                    continue;
                }

                echo $this->getOldPercent($price, $purc);
            }
        }

        print_r($empty_ids);
    }
}