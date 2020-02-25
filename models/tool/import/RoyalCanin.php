<?php

namespace app\models\tool\import;


use app\models\entity\Product;
use app\models\entity\Vendor;
use app\models\helpers\ProductHelper;
use app\models\helpers\ProductPropertiesHelper;
use app\models\tool\Debug;
use yii\helpers\ArrayHelper;

class RoyalCanin
{
	private $not_found_articles = array();
	private $is_update_vendor = false;
	private $vendor_id = 3;

	/**
	 * @param bool $is_update_vendor
	 */
	public function setIsUpdateVendor($is_update_vendor)
	{
		$this->is_update_vendor = $is_update_vendor;
	}

	public function __construct()
	{

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

				$product = Product::find()->where(['code' => $article])->one();
				$vendor = Vendor::findOne($this->vendor_id);

				if (!$vendor) {
					return false;
				}

				if (!$product) {
					$this->not_found_articles[] = $article;
					continue;
				}

				$product->scenario = Product::SCENARIO_UPDATE_PRODUCT;
				$product->base_price = intval($purchase);
				$product->purchase = $product->base_price - ceil($product->base_price * ($vendor->discount / 100));
				$product->price = $product->purchase + ceil($product->purchase * ($this->calcSelfDiscount(ProductPropertiesHelper::getProductWeight($product->id)) / 100));

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


	private function getPricePath()
	{
		return \Yii::getAlias('@app') . "/tmp/royal_2020.csv";
	}

	private function calcSelfDiscount($weight)
	{
		$discount = 30;

		if ($weight > 1) {
			$discount = 10;
		}

		return $discount;
	}
}