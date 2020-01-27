<?php

namespace app\widgets\inspector;


use yii\base\Widget;

class InspectorWidget extends Widget
{
	public $template = 'default';

	public function run()
	{
		return $this->render($this->template);
	}
}