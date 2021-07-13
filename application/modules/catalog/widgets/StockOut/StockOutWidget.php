<?php

namespace app\modules\catalog\widgets\StockOut;


use app\modules\catalog\models\entity\Offers;
use yii\base\Widget;

class StockOutWidget extends Widget
{
	public $view = 'default';

	public function run()
	{
		$products = Offers::find()->where(['>', 'count', 0])->all();
		return $this->render($this->view, [
			'products' => $products
		]);
	}
}