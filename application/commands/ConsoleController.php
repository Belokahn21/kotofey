<?php

namespace app\commands;

use app\modules\catalog\models\entity\Product;
use yii\console\Controller;

class ConsoleController extends Controller
{
	public function actionRun()
	{
		$products = Product::find()->where(['vendor_id' => 12])->all();
		foreach ($products as $product) {
			$product->scenario = Product::SCENARIO_UPDATE_PRODUCT;
			$old = $product->price;
			$product->price += 10;
			if ($product->validate()) {
				if ($product->update()) {
					echo $product->name . '-' . $old . '-' . $product->price;
					echo PHP_EOL;
				}
			}
		}
	}

	public function actionClearCache()
	{
		\Yii::$app->cache->flush();
	}
}
