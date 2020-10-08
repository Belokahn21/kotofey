<?php

namespace app\modules\catalog\widgets\stockOut;


use app\modules\catalog\models\entity\Product;
use yii\base\Widget;

class StockOutWidget extends Widget
{
	public $view = 'default';

	public function run()
	{
		$products = Product::find()->where(['>', 'count', 0])->all();
		return $this->render($this->view, [
			'products' => $products
		]);
	}
}