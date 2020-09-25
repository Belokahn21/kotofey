<?php

namespace app\models\tool\import;


use app\modules\catalog\models\entity\Product;
use app\modules\catalog\models\entity\ProductPropertiesValues;
use app\modules\catalog\models\helpers\ProductPropertiesValuesHelper;
use app\modules\vendors\models\entity\Vendor;
use app\modules\catalog\models\helpers\ProductPropertiesHelper;
use app\models\tool\Debug;

class Valta
{
    public function import()
    {
        if (($handle = fopen($this->getPricePath(), "r")) !== false) {
            while (($line = fgetcsv($handle, 1000, ";")) !== false) {

                $article = $this->getValue($line, 1);
                $rus_name = $this->getValue($line, 2);
                $purchase = $this->getValue($line, 6);
                $weight = $this->getValue($line, 8);
                $barcode = $this->getValue($line, 9);

                if (!is_numeric($article)) {
                    continue;
                }

                $purchase = floor($purchase);

                $product = new Product();
                $product->scenario = Product::SCENARIO_NEW_PRODUCT;
                $product->name = $rus_name;
                $product->base_price = $purchase;
                $product->purchase = $product->base_price;
                $product->price = ceil($product->purchase + $product->purchase * 0.20);
                $product->count = 0;
                $product->vendor_id = 10;
                $product->article = $article;
                $product->barcode = $barcode;
                $product->status_id = Product::STATUS_DRAFT;


                if (!$product->validate()) {
                    Debug::p('Товар ' . $rus_name . ' не прошел проверку\n');
                    Debug::p($product->getErrors());
                }

                if (!$product->save()) {
                    Debug::p('Товар ' . $rus_name . ' не сохранился\n');
                }

                ProductPropertiesValuesHelper::savePropertyValue($product->id, 1, '213'); // Monge производитель
                ProductPropertiesValuesHelper::savePropertyValue($product->id, 2, $weight); // Вес
                ProductPropertiesValuesHelper::savePropertyValue($product->id, 6, '46'); // Страна проиволитель
            }
            fclose($handle);
        }
    }


    private function getPricePath()
    {
        return \Yii::getAlias('@app') . "/tmp/valta.csv";
    }

    private function getValue($data, $pos)
    {
        return array_key_exists($pos, $data) ? $data[$pos] : false;
    }
}