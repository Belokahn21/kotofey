<?php

namespace app\modules\order\widgets\map;


use app\modules\order\models\entity\Order;
use yii\base\Widget;

/**
 * @var $model Order
 *
 */
class MapWidget extends Widget
{
	public $view = 'default';
	public $model;

	public function run()
	{
		return $this->render($this->view, [
			'model' => $this->model
		]);
	}
}