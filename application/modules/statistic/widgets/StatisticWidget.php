<?php

namespace app\modules\statistic\widgets;


use yii\base\Widget;

class StatisticWidget extends Widget
{
	public $view = 'default';

	public function run()
	{
		return $this->render($this->view);
	}
}