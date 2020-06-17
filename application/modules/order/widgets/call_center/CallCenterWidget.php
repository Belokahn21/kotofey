<?php

namespace app\modules\order\widgets\call_center;


use app\modules\order\models\entity\Order;
use yii\base\Widget;

class CallCenterWidget extends Widget
{
	public $view = 'default';
	public $order_id;

	public function run()
	{
		if (empty($this->order_id)) {
			return false;
		}

		$order = Order::findOne($this->order_id);

		return $this->render($this->view, [
			'order' => $order
		]);
	}
}