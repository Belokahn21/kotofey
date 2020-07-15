<?php

namespace app\modules\basket\widgets\productControl;


use yii\base\Widget;

class ProductControlWidget extends Widget
{
	public $view = 'default';
	public $product_id;

	public function run()
	{
		if (empty($this->product_id)) {
			return false;
		}
		return $this->render($this->view, [
			'product_id' => $this->product_id
		]);
	}
}