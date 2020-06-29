<?php

namespace app\models\tool\import;


use app\modules\catalog\models\entity\Product;
use app\models\entity\Vendor;
use app\modules\catalog\models\helpers\ProductPropertiesHelper;
use app\models\tool\Debug;

class Valta
{
	public function import()
	{
		if (($handle = fopen($this->getPricePath(), "r")) !== false) {
			while (($line = fgetcsv($handle, 1000, ";")) !== false) {
				$article = $line[1];
				$rus_name = $line[2];
				$purchase = $line[6];
				$count_in_pack = $line[7];
				$weight = $line[8];

				if (!is_numeric($article)) {
					continue;
				}

				$product = new Product();
				$product->name = $rus_name;
				$product->base_price = $purchase;
				$product->purchase = $product->base_price;
				$product->price = ceil($product->purchase + $product->purchase * 0.30);
				$product->count = 0;
				$product->vendor_id = 10;

			}
			fclose($handle);
		}
	}


	private function getPricePath()
	{
		return \Yii::getAlias('@app') . "/tmp/valta.csv";
	}
}