<?php

namespace app\models\tool\import;


use app\modules\catalog\models\entity\Offers;
use app\modules\vendors\models\entity\Vendor;
use app\modules\catalog\models\helpers\OfferHelper;
use app\modules\catalog\models\helpers\PropertiesHelper;
use app\modules\site\models\tools\Debug;
use yii\helpers\ArrayHelper;

class RoyalCanin extends Importer
{
    private $not_found_articles = array();
    private $is_update_vendor = false;
    private $vendor_id = 3;
    private $prices_folder;


    /**
     * @param bool $is_update_vendor
     */
    public function setIsUpdateVendor($is_update_vendor)
    {
        $this->is_update_vendor = $is_update_vendor;
    }

    /**
     * @return mixed
     */
    public function getPricesFolder()
    {
        return $this->prices_folder;
    }

    /**
     * @param mixed $prices_folder
     */
    public function setPricesFolder($prices_folder)
    {
        $this->prices_folder = $prices_folder;
    }

    public function __construct()
    {
        $this->setPricesFolder(\Yii::getAlias('@app') . "/tmp/price/royal_canin/");
    }

    public function update()
    {
        if (($handle = fopen($this->getPricePath(), "r")) !== false) {
            while (($line = fgetcsv($handle, 1000, ";")) !== false) {
                $article = $line[0];
                $rus_name = $line[1];
                $count_in_pack = $line[2];
                $purchase = $line[3];

                if (empty($article) or empty($rus_name) or empty($count_in_pack) or empty($purchase) or !is_numeric($article)) {
                    continue;
                }

                $product = Offers::find()->where(['code' => $article])->one();
                $vendor = Vendor::findOne($this->vendor_id);

                if (!$vendor) {
                    return false;
                }

                if (!$product) {
                    $this->not_found_articles[] = $article;
                    continue;
                }

                $product->scenario = Offers::SCENARIO_UPDATE_PRODUCT;
                $product->base_price = intval($purchase);
                $oldMarkup = $this->getOldPercent($product->price,$product->purchase);
                $product->purchase = $product->base_price - ceil($product->base_price * ($vendor->discount / 100));
                $product->price = $product->purchase + round($product->purchase * (20 / 100));
//                $product->price = $product->purchase + ceil($product->purchase * ($this->calcSelfDiscount(ProductPropertiesHelper::getProductWeight($product->id)) / 100));

                // Обновить поставщика
                if ($this->is_update_vendor === true && !empty($this->vendor_id)) {
                    $product->vendor_id = $this->vendor_id;
                }

                if ($product->validate()) {
                    if ($product->update() === false) {
                        Debug::p($product->getErrors());
                        return false;
                    }
                    echo " Успешно обновлён: " . $product->name . PHP_EOL;
                } else {
                    Debug::p($product->code);
                    echo PHP_EOL;
                    Debug::p($product->getErrors());
                }
            }
            fclose($handle);
        }

        if ($this->not_found_articles) {
            echo sprintf("Не найдены товары со следующими артикулами (%s шт.): ", count($this->not_found_articles));
            Debug::p($this->not_found_articles);
        }

        return true;
    }


    public function getPricePath()
    {
        return \Yii::getAlias('@app') . "/tmp/price/royal_canin/" . $this->getActualPriceFile();
    }

    private function getActualPriceFile()
    {
        if (is_dir($this->getPricesFolder())) {
            $files = $this->getContainFolder();
            $sortFiles = array();

            foreach ($files as $file) {
                $created_at = fileatime($this->getPricesFolder() . $file);
                $sortFiles[md5($file)] = [
                    'time' => $created_at,
                    'name' => $file
                ];
            }

            usort($sortFiles, function ($a, $b) {
                return $b['time'] - $a['time'];
            });

            return array_shift($sortFiles)['name'];
        }
        return false;
    }

    private function getContainFolder()
    {
        $dir = scandir($this->getPricesFolder());
        unset($dir[0]);
        unset($dir[1]);
        return $dir;
    }
}