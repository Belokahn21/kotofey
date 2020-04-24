<?php

namespace app\modules\order\controllers;

use app\widgets\notification\Alert;
use Yii;
use app\models\entity\Delivery;
use app\modules\order\models\entity\Order;
use app\models\entity\OrdersItems;
use app\models\entity\OrderStatus;
use app\models\entity\Payment;
use app\models\entity\User;
use yii\db\Exception;
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
			$transaction = \Yii::$app->db->beginTransaction();

			if ($model->load(\Yii::$app->request->post())) {

				if ($model->validate()) {
					if (!$model->save()) {
						$transaction->rollBack();
						return $this->refresh();
					}
				}

				$count = count(Yii::$app->request->post('OrdersItems', []));

				$items = [new OrdersItems()];

				for ($i = 1; $i < $count; $i++) {
					$items[] = new OrdersItems();
				}

				if (OrdersItems::loadMultiple($items, Yii::$app->request->post())) {

					foreach ($items as $item) {
						$item->order_id = $model->id;
						if ($item->validate()) {
							if (!$item->save()) {
								$transaction->rollBack();
								return $this->refresh();
							}
						}
					}

				}


				$transaction->commit();
				Alert::setSuccessNotify('Заказ успешно создан');
				return $this->refresh();
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

	public function actionDelete($id)
	{
		try {
			Order::findOne($id)->delete();
		} catch (\Throwable $exception) {
		}

		return $this->redirect('index');
	}
}
