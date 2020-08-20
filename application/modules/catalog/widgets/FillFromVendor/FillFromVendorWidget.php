<?php

namespace app\modules\catalog\widgets\FillFromVendor;


use yii\base\Widget;

class FillFromVendorWidget extends Widget
{
	public $view = 'default';

	public function run()
	{
		return $this->render($this->view);
	}
}