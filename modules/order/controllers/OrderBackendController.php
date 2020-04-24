<?php

namespace app\modules\order\controllers;

use app\models\entity\Delivery;
use app\models\entity\Order;
use app\models\entity\OrdersItems;
use app\models\entity\OrderStatus;
use app\models\entity\Payment;
use app\models\entity\User;
use yii\web\Controller;

class OrderBackendController extends Controller
{
	public $layout = '@app/views/layouts/admin';

	public function actionIndex()
	{
		$model = new Order();
		$itemsModel = new OrdersItems();
		$users = User::find()->all();
		$deliveries = Delivery::find()->all();
		$payments = Payment::find()->all();
		$status = OrderStatus::find()->all();

		if (\Yii::$app->request->isPost) {
			if ($model->load(\Yii::$app->request->post())) {
				if ($model->validate()) {
					if ($model->save()) {
						return $this->refresh();
					}
				}
			}
		}
		return $this->render('index', [
			'itemsModel' => $itemsModel,
			'users' => $users,
			'model' => $model,
			'deliveries' => $deliveries,
			'payments' => $payments,
			'status' => $status,
		]);
	}
}
