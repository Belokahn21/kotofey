<?php

namespace app\models\tool\import;


use app\modules\catalog\models\entity\Product;
use app\modules\catalog\models\entity\ProductOrder;
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

                $purchase = str_replace(',', '.', $purchase);
                $purchase = str_replace(' ', '', $purchase);
                $weight = str_replace(',', '.', $weight);

                $purchase = round($purchase);


                $product = new Product();
                $product->scenario = Product::SCENARIO_NEW_PRODUCT;
                $product->name = $rus_name;
                $product->base_price = $purchase;
                $product->purchase = $product->base_price;
                $product->price = ceil($product->purchase + $product->purchase * 0.20);
                $product->count = 0;
                $product->vitrine = 1;
                $product->vendor_id = 10;
                $product->code = $article;
                $product->barcode = $barcode;
                $product->status_id = Product::STATUS_DRAFT;
                $product->stock_id = 1;
                $product->stock_id = 1;
                $product->feed = "монж";


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
                ProductPropertiesValuesHelper::savePropertyValue($product->id, 9, '111'); // назначение: повседневное питание

                if (strpos($rus_name, 'корм') !== false) {
                    ProductPropertiesValuesHelper::savePropertyValue($product->id, 3, '4'); // тип корма: сухой
                }
                if (strpos($rus_name, 'консервы') !== false) {
                    ProductPropertiesValuesHelper::savePropertyValue($product->id, 3, '14'); // тип корма: консерва
                }

                $orderProduct = new ProductOrder();
                $orderProduct->product_id = $product->id;
                $orderProduct->start = 3;
                $orderProduct->end = 7;

                if (!$orderProduct->validate()) {
                    Debug::p("Заказ продукта не прошел валидацию");
                    Debug::p($orderProduct->getErrors());
                }

                if (!$orderProduct->save()) {
                    Debug::p("Заказ продукта не сохранился");
                    Debug::p($orderProduct->getErrors());
                }
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