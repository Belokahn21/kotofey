<?php

namespace app\commands;

use app\models\tool\Debug;
use app\modules\catalog\models\entity\Product;
use yii\console\Controller;

class ConsoleController extends Controller
{
	public function actionRun()
	{
		$products = Product::find()->all();
		/* @var $product Product */
		foreach ($products as $product) {
			$product->scenario = Product::SCENARIO_UPDATE_PRODUCT;
			$product->discount_price = null;

			if ($product->validate()) {
				$product->update();
			} else {
				Debug::p($product->name);
				echo PHP_EOL;
				Debug::p($product->code);
				echo PHP_EOL;
				Debug::p($product->getErrors());
				return;
			}
		}
	}

	public function actionClearCache()
	{
		\Yii::$app->cache->flush();
	}
}
