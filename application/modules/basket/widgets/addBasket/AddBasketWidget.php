<?php

namespace app\modules\basket\widgets\addBasket;


use yii\base\Widget;

class AddBasketWidget extends Widget
{
	public $product_id;
	public $count = 1;
	public $view = 'default';

	public function run()
	{
		if (empty($this->product_id)) {
			return false;
		}

		return $this->render($this->view, [
			'product_id' => $this->product_id,
			'count' => $this->count,
		]);
	}
}