<?php

namespace app\modules\subscribe\widgets\subscribe;


use app\modules\subscribe\models\entity\Subscribe;
use yii\base\Widget;

class SubscribeWidget extends Widget
{
	public $view = 'default';

	public function run()
	{
		$model = new Subscribe();

		return $this->render($this->view, [
			'model' => $model
		]);
	}
}