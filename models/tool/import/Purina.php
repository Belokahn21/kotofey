<?php

namespace app\models\tool\import;


use app\models\entity\Product;
use app\models\tool\Debug;

class Purina
{
    const PURINA_COMMON = 1;
    const PURINA_FELIX = 2;
    const PURINA_SPECIAL = 3;
    const PURINA_WETONE = 4;

    private $empty_codes = array();

    public function update($type = self::PURINA_COMMON)
    {
        if (($handle = fopen($this->getPricePath($type), "r")) !== false) {
            while (($line = fgetcsv($handle, 1000, ";")) !== false) {
                switch ($type) {
                    case self::PURINA_COMMON:
                        $this->uploadCommon($line);
                        break;
                    case self::PURINA_FELIX:
                        $this->uploadFelix($line);
                        break;
                    case self::PURINA_SPECIAL:
                        $this->uploadSpecial($line);
                        break;
                    case self::PURINA_WETONE:
                        $this->uploadWetone($line);
                        break;
                }
            }
        }
    }

    private function uploadCommon($dataLine)
    {
        $code = $dataLine[1];

        if (!is_numeric($code)) {
            return;
        }

        $price = ceil($dataLine[3]);

        $this->updateProduct($price, $code);
    }

    private function uploadFelix($dataLine)
    {
        $code = $dataLine[1];

        if (!is_numeric($code)) {
            return;
        }

        $price = ceil($dataLine[3]);

        $this->updateProduct($price, $code);
    }

    private function uploadSpecial($dataLine)
    {
        $code = $dataLine[1];

        if (!is_numeric($code)) {
            return;
        }

        $price = ceil($dataLine[3]);

        $this->updateProduct($price, $code);
    }

    private function uploadWetone($dataLine)
    {
        $code = $dataLine[1];

        if (!is_numeric($code)) {
            return;
        }

        $price = ceil($dataLine[3]);

        $this->updateProduct($price, $code);
    }

    private function updateProduct($price, $code)
    {
        $product = Product::findOneByCode($code);
        if ($product) {
            $product->scenario = Product::SCENARIO_UPDATE_PRODUCT;
            $product->active = 1;
            $product->base_price = $price;
            $product->purchase = $product->base_price;
            $product->price = $product->purchase + (ceil($product->purchase * 0.25));

            if ($product->validate()) {
                if ($product->update()) {
                    return true;
                }
            }

        } else {
            $this->empty_codes[] = $code;
        }


        if ($this->empty_codes) {
            echo "Отстуствуют товары с кодами:" . PHP_EOL;
            Debug::p($this->empty_codes);
        }
    }

    private function getPricePath($typeProduct)
    {
        return \Yii::getAlias('@app') . "/tmp/" . $this->libCsv($typeProduct);
    }

    private function libCsv($type)
    {
        $lib[self::PURINA_COMMON] = 'bak_purina.csv';
        $lib[self::PURINA_FELIX] = 'felix_purina.csv';
        $lib[self::PURINA_SPECIAL] = 'spec_purina.csv';
        $lib[self::PURINA_WETONE] = 'wetone_purina.csv';
        return $lib[$type];
    }
}